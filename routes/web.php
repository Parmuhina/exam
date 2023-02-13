<?php

use App\Http\Controllers\CodesController;
use App\Http\Controllers\NewAccountController;
use App\Http\Controllers\NewPaymentController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/start', function () {
    return to_route('home');
});

Route::get('/dashboard', function () {
    $account= Auth::user()->accounts;
    return view('dashboard',['accounts'=>$account]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/newPayment', [NewPaymentController::class, 'show'])->name('newPayment');
    Route::post('/newPayment', [NewPaymentController::class, 'newPayment']);
    Route::get('/newAccount', [NewAccountController::class, 'show'])->name('newAccount');
    Route::get('/codes', [CodesController::class, 'show'])->name('codes');

});

require __DIR__.'/auth.php';
