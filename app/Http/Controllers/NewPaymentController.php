<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeValidation;
use App\Models\CurrencyTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CurrencyPriceRequest;

class NewPaymentController extends Controller
{
    public function show(Request $request): View
    {
        $number = random_int(1, 36);
        $request->session()->put('number', $number);
        $account = Auth::user()->accounts;
        return view('auth.newPayment', ['accounts' => $account, 'number' => $number, 'error' => '']);
    }

    public function newPayment(Request $request): RedirectResponse
    {

        $codeFour = $request->session()->get('number');
        $codeValidation = new CodeValidation();

        if ($codeValidation->checkCodeFour($request->get('securityCode'), $codeFour) === true) {
            $request->validate([
                //'sendersAccount' => ['required', 'string', 'max:255'],
                'sendersName' => ['required', 'string', 'max:255'],
                'amountMoney' => ['required', 'numeric', 'min:0'],
                'securityCode' => ['required', 'numeric', 'digits:4'],
            ]);

            $symbolFrom = (Account::where('account_number', $request->get('accountNumber'))->firstOrFail())->currency_symbol;

            $symbolTo = (Account::where('account_number', $request->get('sendersAccount'))->firstOrFail())->currency_symbol;

            $amount = floatval($request->amountMoney);

            if ($symbolTo != $symbolFrom) {
                foreach ((new CurrencyPriceRequest())->currencyPrice() as $currency) {
                    if ($currency->getId() === $symbolFrom) {
                        $amount = floatval($request->amountMoney) / $currency->getRate();
                    }
                }
            }
            if ($amount * 100 <= (Account::where('account_number', $request->get('accountNumber'))->firstOrFail())->currency_amount) {
                $currencyTransaction = (new CurrencyTransaction())->fill([
                    'from_account' => (Account::where('account_number', $request->get('accountNumber'))->firstOrFail())->account_number,
                    'to_account' => (Account::where('account_number', $request->get('sendersAccount'))->firstOrFail())->account_number,
                    'symbol' => $symbolTo,
                    'amount' => $amount * 100,
                    'senders_name' => $request->get('sendersName')
                ]);
                $currencyTransaction->user()->associate(Auth::user());
                $currencyTransaction->save();

                $account = Account::where('account_number', $request->get('accountNumber'))->firstOrFail();
                $account->currency_amount = $account->currency_amount - $amount * 100;
                $account->save();

                $account = Account::where('account_number', $request->get('sendersAccount'))->firstOrFail();
                $account->currency_amount = $account->currency_amount + $amount * 100;
                $account->save();
                $error = 'You create new payment!';
            } else {
                $error = 'Not enough money!';
            }
        } else {
            $error = 'Wrong security code!';

        }
        $request->session()->forget('number');
        return back()->with('status', 'new-payment-created');
    }
}
