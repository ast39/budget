<?php

namespace App\Packages\Finance\Safe;

use App\Packages\Finance\Safe\RequestData;

class ResponseData {

    # Объект сейфа запроса
    public  RequestData $safe;

    # Начальная сумма
    public float $amount            = 0;

    # Сумма всех пополнений
    public float $total_deposits    = 0;

    # Сумма всех снятий
    public float $total_withdrawals = 0;

    # Кол-во всех пополнений
    public float $count_deposits    = 0;

    # Кол-во всех снятий
    public float $count_withdrawals = 0;

    # Текущий баланс
    public float $balance           = 0;

    # График транзакций в сейфе
    public array $details;


    /**
     * @param RequestData $safe
     * @param array $details
     */
    public function __construct(
        RequestData $safe,
        array $details,
    )
    {
        $this->safe   = $safe;
        $this->amount = $safe->amount;

        $this->total_deposits = round(array_sum(array_map(function ($e) {
            return max($e['transaction_amount'], 0);
        }, $details)), 2);

        $this->total_withdrawals = round(array_sum(array_map(function ($e) {
            return min($e['transaction_amount'], 0);
        }, $details)), 2);

        $this->count_deposits = count(array_filter($details, function ($e) {
            return $e['transaction_amount'] > 0;
        }));

        $this->count_withdrawals = count(array_filter($details, function ($e) {
            return $e['transaction_amount'] < 0;
        }));

        $this->balance = round($this->amount + $this->total_deposits + $this->total_withdrawals, 2);
        $this->details = $details;
    }

}
