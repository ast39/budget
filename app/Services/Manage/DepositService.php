<?php

namespace App\Services\Manage;

use App\Models\Manage\Deposit;
use Illuminate\Support\Facades\Auth;

class DepositService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data):? int
    {
        $data['owner_id']   = Auth::id();
        $data['start_date'] = strtotime(($data['start_date'] ?? date('d-m-Y', time())) . ' 09:00:00');
        $data['withdrawal'] = ($data['withdrawal'] ?? 'off') == 'on' ? 1 : 0;

        return Deposit::create($data)->deposit_id;
    }

    /**
     * @param int $id
     * @param $data
     * @return void
     */
    public function update(int $id, $data): void
    {
        $deposit = Deposit::where('owner_id', Auth::id())
            ->findOrFail($id);

        $data['owner_id']   = Auth::id();
        $data['start_date'] = strtotime(($data['start_date'] ?? date('d-m-Y', time())) . ' 09:00:00');
        $data['withdrawal'] = ($data['withdrawal'] ?? 'off') == 'on' ? 1 : 0;

        $deposit->update($data);
    }

    public function destroy(int $id): void
    {
        $deposit = Deposit::where('owner_id', Auth::id())
            ->findOrFail($id);

        $deposit->delete();
    }
}
