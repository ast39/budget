<?php

namespace App\Packages\Finance\Safe;

/**
 * Объект кредита - запрос
 */
class RequestData {

    # Название сейфа
    public string $title;

    # Стартовый баланс
    public ?float $amount;

    # Список транзакций
    public ?array $payments;


    /**
     * @param string $title
     * @param float|null $amount
     * @param array|null $payments
     */
    public function __construct(
        string  $title,
        ?float  $amount   = null,
        ?array  $payments = null,
    ) {
        $this->title    = $title;
        $this->amount   = (float) str_replace(',', '.', $amount ?: 0);
        $this->payments = $payments ?: [];
    }

}
