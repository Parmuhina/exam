<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeValidation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewAccountController extends Controller
{
    public function show(Request $request): Application|Factory|View
    {
        $account = Auth::user()->accounts;
        $number = random_int(1, 36);
        $request->session()->put('number', $number);
        return view('auth.newAccount', ['accounts' => $account, 'number' => $number, 'error' => '']);
    }

    public function newAccount(Request $request): Application|Factory|View
    {
        $codeFour = $request->session()->get('number');
        $accountNumber = '';

        $account = Auth::user()->accounts;
        $request->validate([
            'currencySymbol' => ['string', 'nullable', 'size:3', 'uppercase'],
            'amountMoney' => ['numeric', 'min:0'],
            'securityCode' => ['required', 'numeric', 'digits:4'],
        ]);
        $codeValidation = new CodeValidation();

        if ($codeValidation->checkCodeFour($request->get('securityCode'), $codeFour) === true) {

            $symbol = (strlen($request->currencySymbol) === 0 ? 'EUR' : $request->currencySymbol);
            $amount = (strlen($request->amountMoney) === 0 ? 0 : $request->amountMoney);

            do {
                $accountNumber = 'SA' . random_int(1000, 9999) . 'BA' . random_int(1000000000, 9999999999);

                $accounts = Account::where('account_number', $accountNumber)
                    ->get()
                    ->first();
            } while ($accounts != null);

            $account = (new Account())->fill([
                'account_number' => $accountNumber,
                'currency_symbol' => $symbol,
                'currency_amount' => $amount
            ]);

            $account->user()->associate(Auth::user());
            $account->save();
            $error = 'You create new account!';
        } else {
            $error = 'Wrong security code!';

        }
        $request->session()->forget('number');

        return view('auth.newAccount', ['accounts' => $account, 'number' => $codeFour, 'error' => $error]);
    }

}
