<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BuySellCryptoController;
use App\Http\Controllers\CryptoHistoryController;
use App\Http\Controllers\NewAccountController;
use App\Http\Controllers\NewCryptoAccountController;
use App\Http\Controllers\NewPaymentController;
use App\Http\Controllers\PaymentHistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('newAccount', [NewAccountController::class, 'newAccount'])->name('newAccount');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    Route::get('paymentHistory', [PaymentHistoryController::class, 'show'])->name('paymentHistory');
    Route::post('currencyFilter', [PaymentHistoryController::class, 'filter'])->name('currencyFilter');
    Route::get('newCryptoAccount', [NewCryptoAccountController::class, 'show'])->name('newCryptoAccount');
    Route::post('newCryptoAccount', [NewCryptoAccountController::class, 'newCryptoAccount']);
    Route::get('buySellCrypto', [BuySellCryptoController::class, 'show'])->name('buySellCrypto');
    Route::post('buyCrypto', [BuySellCryptoController::class, 'buyCrypto'])->name('buyCrypto');
    Route::post('sellCrypto', [BuySellCryptoController::class, 'sellCrypto'])->name('sellCrypto');
    Route::get('cryptoHistory', [CryptoHistoryController::class, 'show'])->name('cryptoHistory');
    Route::post('cryptoFilter', [CryptoHistoryController::class, 'filter'])->name('cryptoFilter');

});
