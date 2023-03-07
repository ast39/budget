<?php

namespace App\Services\Payment;

use App\Models\Payment\CreditPayment as CreditPayment;

class CreditService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data): ?int
    {
        return CreditPayment::create($data)->payment_id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $payment = CreditPayment::findOrFaill($id);
        $payment->delete();
    }

}
