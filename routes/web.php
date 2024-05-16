<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BankingController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/users/create', [UserController::class, 'createPage'])->name('users.create');
    Route::post('/users', [UserController::class, 'createUser'])->name('users.store');

    // banking
    Route::get('/show-transactions', [BankingController::class, 'showTransactions'])->name('banking.transactions');

    // deposit
    Route::get('/deposit', [BankingController::class, 'showDeposits'])->name('banking.deposits');
    Route::post('/deposit', [BankingController::class, 'deposit'])->name('banking.deposit');

    Route::get('/withdrawal', [BankingController::class, 'showWithdrawals'])->name('banking.withdrawals');
    Route::post('/withdrawal', [BankingController::class, 'withdraw'])->name('banking.withdraw.amount');
});

require __DIR__ . '/auth.php';
