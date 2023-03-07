<?php

namespace App\Packages\Finance\Deposit;

use App\Packages\Finance\Exceptions\RequestDataException;
use App\Packages\Finance\PlowBack;

/**
 * Объект вклада - запрос
 */
class RequestData {

    # ID вклада
    public ?int $deposit_id;

    # Название вклада
    public string $title;

    # Сумма вклада
    public float  $amount;

    # Процент по вкладу
    public float  $percent;

    # Срок вклада
    public int    $period;

    # Дата открытия вклада
    public int    $start_date;

    # Ежемесячное пополнение
    public float  $refill;

    # Капитализация процентов (Пример: PlowBack::DAILY)
    public int    $plow_back;

    # Будут ли проценты сниматься каждый месяц
    public bool   $withdrawal;

    /**
     * @param string $title
     * @param float $amount
     * @param float $percent
     * @param int $period
     * @param float $refill
     * @param int $plow_back
     * @param bool $withdrawal
     * @param int|null $start_date
     * @throws RequestDataException
     */
    public function __construct(
        string $title,
        float  $amount,
        float  $percent,
        int    $period,
        float  $refill,
        int    $plow_back,
        bool   $withdrawal,
        ?int   $start_date = null,
        ?int   $deposit_id = null,
    )
    {
        $this->title      = $title;
        $this->amount     = (float) str_replace(',', '.', $amount);
        $this->percent    = (float) str_replace(',', '.', $percent);
        $this->period     = $period;
        $this->refill     = (float) str_replace(',', '.', $refill);
        $this->plow_back  = $plow_back;
        $this->withdrawal = $withdrawal;
        $this->start_date = $start_date ?: time();
        $this->deposit_id = $deposit_id ?: null;

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

        if ($this->refill < 0) {
            throw new RequestDataException('Refill can\'t be lower or zero', 906);
        }

        if (!PlowBack::enum($this->plow_back)) {
            throw new RequestDataException('Plow back must be enum by PlowBack class', 907);
        }
    }
}
