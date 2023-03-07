<?php

namespace App\Services\Calculate;

use App\Models\Calculate\Deposit;
use App\Packages\Finance\Deposit\Manager;
use App\Packages\Finance\Deposit\ResponseData;
use App\Packages\Finance\Exceptions\RequestDataException;

class DepositService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data):? int
    {
        $data['withdrawal'] = ($data['withdrawal'] ?? 'off') == 'on' ? 1 : 0;
        $data['start_date'] = strtotime(($data['start_date'] ?? date('d-m-Y', time())) . ' 09:00:00');

        return Deposit::create($data)->deposit_id;
    }

    /**
     * @param int $id
     * @return ResponseData|null
     * @throws RequestDataException
     */
    public function calculate(int $id):? ResponseData
    {
        $deposit = Deposit::findOrFail($id);
        $data    = $deposit;
        $deposit->delete();

        return
            Manager::calculate(
                Manager::setDeposit(
                    $data->title, $data->amount, $data->percent, $data->period,
                    $data->refill, $data->plow_back, $data->withdrawal, $data->start_date,
                )
            );
    }

}
