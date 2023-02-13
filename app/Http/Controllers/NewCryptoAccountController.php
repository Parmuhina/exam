<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountNumberValidation;
use App\Models\CodeValidation;
use Illuminate\Console\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewCryptoAccountController extends Controller
{
    public function show(Request $request): Application|Factory|\Illuminate\Contracts\View\View
    {
        $number = random_int(1, 36);
        $request->session()->put('number', $number);
        $account= Auth::user()->accounts;
        return view('auth.newCryptoAccount', ['accounts'=>$account, 'number'=>$number, 'error'=>'']);
    }

    public function newCryptoAccount(Request $request): RedirectResponse
    {
        $codeFour = $request->session()->get('number');
        $codeValidation = new CodeValidation();

        if ($codeValidation->checkCodeFour($request->get('securityCode'), $codeFour) === true) {
            $request->validate([
                'securityCode' => ['required', 'numeric', 'digits:4'],
            ]);
            do {
                $accountNumber = 'CRYPTO' . random_int(1000, 9999) . 'BA' . random_int(1000000000, 9999999999);
                $accounts = Account::where('account_number', $accountNumber)
                    ->get()
                    ->first();
            } while ($accounts != null);

            $account = (new Account())->fill([
                'account_number' => $accountNumber,
                'currency_symbol' => "",
                'currency_amount' => 0,

            ]);
            $account->user()->associate(Auth::user());
            $account->save();
            $error = 'You create new account!';
        }else{
            $error = 'Wrong security code!';
        }

        return back()->with('status', 'new-account-created');
    }
}
