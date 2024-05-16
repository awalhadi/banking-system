<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BankingService;

class BankingController extends Controller
{
    public $bankingService;

    public function __construct()
    {
        $this->bankingService = new BankingService();
    }

    // showTransactions
    public function showTransactions()
    {
        $transactionData = $this->bankingService->getTransactions();
        return view('banking.transactions', $transactionData);
    }

    // show diposited transactions
    public function showDeposits()
    {
        $title = 'Deposits';
        $deposits = $this->bankingService->getDeposits();
        return view('banking.single_transaction', ['transactions' => $deposits, 'title' => $title]);
    }

    // deposit money
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);
        try {
            $transaction = $this->bankingService->depositMoney($request);

            return redirect()->route('banking.deposits')->with('status', 'Money deposited successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // show withdrawals
    public function showWithdrawals()
    {
        $withdrawals = $this->bankingService->getWithdrawals();
        return view('banking.single_transaction', ['transactions' => $withdrawals, 'title' => 'Withdrawals']);
    }

    // withdraw money
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);
        try {
            $transaction = $this->bankingService->withdrawMoney($request);
            return redirect()->route('banking.withdrawals')->with('status', 'Money withdrawn successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
