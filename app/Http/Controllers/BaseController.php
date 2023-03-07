<?php

namespace App\Http\Controllers;

use App\Classes\CategoryTree;
use App\Models\Expenses\Category;
use App\Services\Manage\CreditService as ManageCredit;
use App\Services\Manage\DepositService as ManageDeposit;
use App\Services\Manage\WalletService as ManageWallet;

use App\Services\Fraud\CreditService as FraudCredit;

use App\Services\Payment\CreditService as CreditPayment;
use App\Services\Payment\WalletService as WalletPayment;
use App\Services\Payment\ExpenseService as ExpensePayment;

use App\Services\Calculate\CreditService as CalculateCredit;
use App\Services\Calculate\DepositService as CalculateDeposit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class BaseController extends Controller {

    public ManageCredit $manage_credit_service;
    public ManageDeposit $manage_deposit_service;
    public ManageWallet $manage_wallet_service;
    public FraudCredit $fraud_credit_service;
    public CalculateCredit $calculate_credit_service;
    public CalculateDeposit $calculate_deposit_service;
    public CreditPayment $payment_credit_service;
    public WalletPayment $payment_wallet_service;
    public ExpensePayment $payment_expense_service;

    public function __construct(
        ManageCredit     $credit,
        ManageDeposit    $deposit,
        ManageWallet     $wallet,
        FraudCredit      $fraud_credit,
        CalculateCredit  $tmp_credit,
        CalculateDeposit $tmp_deposit,
        CreditPayment    $credit_payment,
        WalletPayment    $wallet_payment,
        ExpensePayment   $expense_payment,

    ) {
        $this->manage_credit_service     = $credit;
        $this->manage_deposit_service    = $deposit;
        $this->manage_wallet_service     = $wallet;
        $this->fraud_credit_service      = $fraud_credit;
        $this->calculate_credit_service  = $tmp_credit;
        $this->calculate_deposit_service = $tmp_deposit;
        $this->payment_credit_service    = $credit_payment;
        $this->payment_wallet_service    = $wallet_payment;
        $this->payment_expense_service   = $expense_payment;
    }

    /**
     * @return array|array[]
     */
    protected function categories(): array
    {
        $cats = Category::all()->toArray();

        $result = [
            'profit' => CategoryTree::getProfitTree($cats),
            'wd'     => CategoryTree::getWdTree($cats),
        ];

        return $result;
    }

}
