<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Code;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Application|Factory|\Illuminate\Contracts\View\View
    {
        return view('NewUserRegistration');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'max:255', 'unique:users,email'],

            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
            //'personal_code' => ['required', 'string', 'max:255', 'unique:users,personal_code'],
            //'number' => ['required', 'string', 'max:255', 'unique:users,telephone_number'],
            //'country' => ['required', 'string', 'max:255'],
            //'address' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'personal_code' => $request->personalCode,
            'email' => $request->email,
            'telephone_number' => $request->number,
            'country' => $request->country,
            'address' => $request->address

        ]);

        $account = (new Account())->fill([
            'account_number' => 'SA' . random_int(1000, 9999) . 'BA' . random_int(1000000000, 9999999999)
        ]);
        $account->user()->associate($user);
        $account->save();

        $fourDigit='';
        $fiveDigit='';
        for($i=1; $i<=36; $i++){
            $fourDigit.= random_int(1000, 9999);
            $fiveDigit.=random_int(10000, 99999);
            if($i!=36){
                $fourDigit.=" ";
                $fiveDigit.=" ";
            }
            }
        $code=(new Code())->fill([
            'four_digit'=>$fourDigit,
            'five_digit'=>$fiveDigit,
        ]);
        $code->user()->associate($user);
        $code->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
