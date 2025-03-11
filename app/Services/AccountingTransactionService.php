<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountingActivity;
use App\Models\AccountingTransaction;
use App\Models\AccountingTransactionDetail;
use App\Models\PaymentMethodAccount;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AccountingTransactionService
{
    /**
     * Record a financial transaction.
     *
     * @param int $debitAccountId
     * @param int $creditAccountId
     * @param int $amount
     * @param string $reference
     * @param string $description
     * @throws \Exception
     */
    public function doubleEntry(int $branch, string $activityName, int $amount, string $reference, string $description, string $date): void
    {
        //find account activity
        $accountActivity = AccountingActivity::whereName($activityName)->first();

        // dd($accountActivity);
        // dd(empty($accountActivity->debit_account_id));

        if ($accountActivity == null || empty($accountActivity->debit_account_id) || empty($accountActivity->credit_account_id)) {
            throw new \Exception('Account Activite Not Found for ' . $activityName);
        } else {
            $debit_id = $accountActivity->debit_account_id;
            $credit_id = $accountActivity->credit_account_id;
        }

        try {
            // Create the main transaction record
            $transaction = AccountingTransaction::create([
                'branch_id' => $branch,
                'date' => $date,
                'reference' => $reference,
                'description' => $description,
            ]);

            // Record the debit transaction detail
            AccountingTransactionDetail::create([
                'accounting_transaction_id' => $transaction->id,
                'account_id' => $debit_id,
                'debit' => $amount,
            ]);

            // Record the credit transaction detail
            AccountingTransactionDetail::create([
                'accounting_transaction_id' => $transaction->id,
                'account_id' => $credit_id,
                'credit' => $amount,
            ]);
        } catch (Exception $e) {
            // dd($e);
            throw new \Exception('Accounting Transaction fial to correct.');
        }
    }

    public function paymentDoubleEntry(string $payment_status, int $payment_method_id, int $branch, string $activityName, int $amount, string $reference, string $description, string $date): void
    {
        //find account activity
        $accountActivity = AccountingActivity::whereName($activityName)->first();
        $paymentMethod = PaymentMethodAccount::wherePaymentMethodId($payment_method_id)->first();

        // dd($accountActivity->credit_account_id);
        //Check account
        if ($accountActivity == null || empty($accountActivity->credit_account_id) || $paymentMethod == null) {
            // dd("Hello");
            throw new \Exception('Account Activite Not Found');
        }

        if ($payment_status == "received") {
            //receivable account
            $debit_id = $paymentMethod->account_id;
            $credit_id = $accountActivity->credit_account_id;
        } elseif ($payment_status == "paid") {
            //payment account
            $debit_id = $accountActivity->debit_account_id;
            $credit_id = $paymentMethod->account_id;
        } else {
            throw new \Exception('payment status wrong in model');
        }


        try {
            // Create the main transaction record
            $transaction = AccountingTransaction::create([
                'branch_id' => $branch,
                'date' => $date,
                'reference' => $reference,
                'description' => $description,
            ]);

            // Record the debit transaction detail
            AccountingTransactionDetail::create([
                'accounting_transaction_id' => $transaction->id,
                'account_id' => $debit_id,
                'debit' => $amount,
            ]);

            // Record the credit transaction detail
            AccountingTransactionDetail::create([
                'accounting_transaction_id' => $transaction->id,
                'account_id' => $credit_id,
                'credit' => $amount,
            ]);
        } catch (Exception $e) {
            // dd($e);
            throw new \Exception('Accounting Transaction fial to correct.');
        }
    }
}
