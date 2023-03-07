<?php

namespace App\Packages\Finance\Safe;

class Core {

    /**
     * Экземпляр кредитного запроса
     *
     * @var RequestData
     */
    protected RequestData $safe;

    /**
     * @param RequestData $safe
     */
    public function __construct(RequestData $safe)
    {
        $this->safe = $safe;
    }

    public function history()
    {
        $details = [];

        $balance = $this->safe->amount;

        foreach ($this->safe->payments as $payment) {

            $details[] = [
                'date_time'          => $payment['created_at'],
                'inset_balance'      => $balance,
                'transaction_amount' => $payment['amount'],
                'outset_balance'     => $balance + $payment['amount'],
                'note'               => $payment['note'],
            ];

            $balance += $payment['amount'];
        }

        return $details;
    }
}
