<?php

namespace App\Services\Payment;

use App\Models\Expenses\Transaction;

class ExpenseService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data): ?int
    {
        return Transaction::create($data)->tr_id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $payment = Transaction::findOrFaill($id);
        $payment->delete();
    }

}
