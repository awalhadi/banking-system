<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BankingService
{

    public function getTransactions()
    {
        $data = [
            'balance' => 0,
            'transactions' => []
        ];

        $user = Auth::user();
        $data['balance'] = $user->balance;
        $transactions = Transaction::where('user_id', $user->id)->paginate(10);
        $data['transactions'] = $transactions;

        return $data;
    }

    // Get deposits
    public function getDeposits()
    {
        $user = Auth::user();
        $deposits = Transaction::where('user_id', $user->id)->where('type', 'deposit')->paginate(10);

        return $deposits;
    }

    // Get withdrawals
    public function getWithdrawals()
    {
        $user = Auth::user();
        $withdrawals = Transaction::where('user_id', $user->id)->where('type', 'withdrawal')->paginate(10);

        return $withdrawals;
    }

    // Deposit money
    public function depositMoney(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);
        $user   = User::find(Auth::user()->id);
        $amount = $validatedData['amount'];

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type'    => 'deposit',
            'amount'  => $amount,
            'fee'     => 0,
        ]);

        $user->balance += $amount;
        $user->save();

        return [
            'transaction' => $transaction,
            'balance'     => $user->balance
        ];
    }

    // Withdraw money
    public function withdrawMoney(Request $request)
    {

        $user   = User::find(Auth::user()->id);
        $amount = $request->amount;
        $fee = $this->calculateWithdrawalFee($user, $amount);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type'    => 'withdrawal',
            'amount'  => $amount,
            'fee'     => $fee,
        ]);

        $user->balance -= ($amount + $fee);
        $user->save();

        return [
            'transaction' => $transaction,
            'balance'     => $user->balance
        ];
    }

    // calculate withdrawal fee
    public function calculateWithdrawalFee($user, $amount)
    {
        $fee = 0;
        $currentDate = Carbon::now();
        // dd($currentDate->isFriday(), Carbon::parse($currentDate)->format('l'));

        // if user type individual
        if ($user->account_type == 'Individual') {
            $fee = $amount * 0.00015; // 0.015% fee

            // if today is Friday return 0
            if ($currentDate->isFriday()) {
                $fee = 0;
            }
            // first 1k is free and remaining is 0.00015
            if ($amount > 1000) {
                $fee = 0.00015 * ($amount - 1000);
            }

            // monthly 5k free
            $monthlyWithdrawals = $user->transactions()->where('type', 'withdrawal')->whereMonth('created_at', $currentDate->month)->sum('amount');
            // dd($fee, $monthlyWithdrawals);
            if ($monthlyWithdrawals + $amount <= 5000) {
                $fee = 0;
            }
        } else {
            $totalWithdrawals = $user->transactions()
                ->where('type', 'withdrawal')
                ->sum('amount');

            // if total withdrawals is less then 5000 then 0.00015 or 0.00025
            if ($totalWithdrawals < 5000) {
                $fee = $amount * 0.00015; // 0.015% fee
            } else {
                $fee = $amount * 0.00025; // 0.025% fee
            }
        }

        return $fee;
    }
}
