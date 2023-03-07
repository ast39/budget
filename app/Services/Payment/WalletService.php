<?php

namespace App\Services\Payment;

use App\Models\Payment\WalletPayment;

class WalletService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data): ?int
    {
        return WalletPayment::create($data)->payment_id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $payment = WalletPayment::findOrFaill($id);
        $payment->delete();
    }
}
