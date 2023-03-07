<?php

namespace App\Packages\Finance\Fraud;

use App\Packages\Finance\Exceptions\RequestDataException;

class RequestData {

    # Название
    public string $title;

    # Сумма
    public float  $amount;

    # Процент
    public float  $percent;

    # Срок
    public int    $period;

    # Ежемесячный платеж
    public float  $payment;

    /**
    * @param string $title
    * @param float $amount
    * @param float $percent
    * @param int $period
    * @param float $payment
    * @throws RequestDataException
    */
    public function __construct(
        string $title,
        float  $amount,
        float  $percent,
        int    $period,
        float  $payment
    ) {
        $this->title   = $title;
        $this->amount  = (float) str_replace(',', '.', $amount);
        $this->percent = (float) str_replace(',', '.', $percent);
        $this->period  = $period;
        $this->payment = (float) str_replace(',', '.', $payment);

        $this->validate();
    }

    /**
     * @return void
     * @throws RequestDataException
     */
    private function validate()
    {
        if ($this->amount <= 0) {
            throw new RequestDataException('Amount can\'t be lower or zero', 901);
        }

        if ($this->percent <= 0) {
            throw new RequestDataException('Percent can\'t be lower or zero', 902);
        }

        if ($this->period <= 0) {
            throw new RequestDataException('Period can\'t be lower or zero', 903);
        }

        if ($this->payment <= 0) {
            throw new RequestDataException('Payment can\'t be lower or zero', 904);
        }

        if ($this->payment >= $this->amount) {
            throw new RequestDataException('Amount can\'t be lower or payment', 905);
        }
    }
}
