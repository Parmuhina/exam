<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeValidation;
use App\Models\Crypto;
use App\Models\CryptoTransaction;
use App\Models\CurrencyPriceRequest;
use App\Models\CurrencyTransaction;
use Illuminate\Console\Application;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuySellCryptoController extends Controller
{
    public function show(Request $request): Application|Factory|View
    {
        $numberBuy = random_int(1, 36);
        $numberSell = random_int(1, 36);
        $request->session()->put('numberBuy', $numberBuy);
        $request->session()->put('numberSell', $numberSell);
        $error = '';
        $symbols = $request->get('symbols') ?? "BTC,ETH,USDT";
        $cryptoInformation = (new Crypto())->crypto($symbols, "EUR");
        if (count((array)$cryptoInformation["data"]) === 0) {
            $symbols = "BTC,ETH,USDT";
            $cryptoInformation = (new Crypto())->crypto($symbols, "EUR");
            $error = 'No crypto information found for the given symbols.';
        }
        $symbol = explode(",", $symbols);
        $logos = [];
        foreach ($symbol as $symbo) {
            $logos[$symbo] = (new Crypto())->logo($symbo);
        }
        $account = Auth::user()->accounts;

        return view('auth.buySellCrypto',
            [
                'accounts' => $account,
                'symbols' => $symbols,
                'cryptoInformation' => $cryptoInformation,
                'logos' => $logos,
                'currency' => 'EUR',
                'error' => $error,
                'errorBuy' => '',
                'errorSell' => '',
                'numberBuy' => $numberBuy,
                'numberSell' => $numberSell
            ]);
    }

    public function buyCrypto(Request $request): RedirectResponse
    {
        $codeFour = $request->session()->get('numberBuy');
        $codeValidation = new CodeValidation();

        if ($codeValidation->checkCodeFour($request->get('securityCode'), $codeFour) === true) {
            $request->validate([
                'amountMoney' => ['required', 'numeric', 'min:0.00000001'],

            ]);

            $symbolFrom = (Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail())->currency_symbol;

            $symbolTo = (Account::where('account_number', $request->get('accountNumberTo'))->firstOrFail())->crypto_symbol;
            if ($symbolTo === "crypto") {
                $symbolTo = $request->get('cryptoSymbol');
            }
            $price = (new Crypto())->crypto($symbolTo, $symbolFrom)["data"];

            $amount = floatval($request->amountMoney) * $price->{$symbolTo}->quote->{$symbolFrom}->price;
            if ($amount * 100 <= Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail()->crypto_amount) {

                $currencyTransaction = (new CryptoTransaction())->fill([
                    'from_account' => (Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail())->account_number,
                    'to_account' => (Account::where('account_number', $request->get('accountNumberTo'))->firstOrFail())->account_number,
                    'symbol' => $symbolTo,
                    'amount' => floatval($request->amountMoney) * 100,
                    'currency_symbol' => $symbolFrom,
                    'bill' => $amount * 100
                ]);
                $currencyTransaction->user()->associate(Auth::user());
                $currencyTransaction->save();

                $account = Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail();
                $account->currency_amount = $account->currency_amount - $amount * 100;
                $account->save();

                $account = Account::where('account_number', $request->get('accountNumberTo'))->firstOrFail();
                $account->crypto_amount = $account->crypto_amount + floatval($request->amountMoney) * 100;
                $account->crypto_symbol = $symbolTo;
                $account->save();
                $errorBuy = 'You create new account!';
            } else {
                $errorBuy = 'You dont have enough crypto!';
            }
        } else {
            $errorBuy = 'Wrong security code!';

        }
        $request->session()->forget('numberBuy');

        return back()->with('status', 'new-payment-created');
    }

    public function sellCrypto(Request $request): RedirectResponse
    {
        $codeFour = $request->session()->get('numberSell');
        $codeValidation = new CodeValidation();

        if ($codeValidation->checkCodeFour($request->get('securityCode'), $codeFour) === true) {
            $request->validate([
                'amountMoney' => ['required', 'numeric', 'min:0.00000001'],
            ]);

            $symbolFrom = (Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail())->crypto_symbol;

            $symbolTo = (Account::where('account_number', $request->get('accountNumberTo'))->firstOrFail())->currency_symbol;

            $price = (new Crypto())->crypto($symbolFrom, $symbolTo)["data"];

            $bill = floatval($request->amountMoney) * $price->{$symbolFrom}->quote->{$symbolTo}->price;
            if (floatval($request->amountMoney) * 100 <= Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail()->crypto_amount) {

                $currencyTransaction = (new CryptoTransaction())->fill([
                    'from_account' => (Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail())->account_number,
                    'to_account' => (Account::where('account_number', $request->get('accountNumberTo'))->firstOrFail())->account_number,
                    'symbol' => $symbolFrom,
                    'amount' => floatval($request->amountMoney) * 100,
                    'currency_symbol' => $symbolTo,
                    'bill' => $bill * 100
                ]);
                $currencyTransaction->user()->associate(Auth::user());
                $currencyTransaction->save();

                $account = Account::where('account_number', $request->get('accountNumberFrom'))->firstOrFail();
                $account->crypto_amount = $account->crypto_amount - floatval($request->amountMoney) * 100;
                $account->save();

                $account = Account::where('account_number', $request->get('accountNumberTo'))->firstOrFail();
                $account->currency_amount = $account->currency_amount + $bill * 100;
                $account->save();
                $errorSell = 'You create new account!';
            } else {
                $errorSell = 'You dont have enough crypto!';
            }
        } else {
            $errorSell = 'Wrong security code!';

        }
        $request->session()->forget('numberSell');

        return back()->with('status', 'new-payment-created');
    }
}
