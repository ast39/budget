<?php

namespace App\Services\Manage;

use App\Models\Manage\Credit;
use Illuminate\Support\Facades\Auth;

class CreditService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data):? int
    {
        $data['owner_id']     = Auth::id();
        $data['start_date']   = strtotime(($data['start_date']   ?? date('d-m-Y', time())) . ' 09:00:00');
        $data['payment_date'] = strtotime(($data['payment_date'] ?? date('d-m-Y', time())) . ' 09:00:00');

        return Credit::create($data)->credit_id;
    }

    /**
     * @param int $id
     * @param $data
     * @return void
     */
    public function update(int $id, $data): void
    {
        $credit = Credit::where('owner_id', Auth::id())
            ->findOrFail($id);

        $data['owner_id']     = Auth::id();
        $data['start_date']   = strtotime(($data['start_date']   ?? date('d-m-Y', time())) . ' 09:00:00');
        $data['payment_date'] = strtotime(($data['payment_date'] ?? date('d-m-Y', time())) . ' 09:00:00');

        $credit->update($data);
    }

    public function destroy(int $id): void
    {
        $credit = Credit::where('owner_id', Auth::id())
            ->findOrFail($id);

        $credit->delete();
    }
}
