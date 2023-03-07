<?php

namespace App\Services\Fraud;

use App\Models\Fraud\Credit;
use App\Packages\Finance\Fraud\Manager;
use App\Packages\Finance\Fraud\ResponseData;
use App\Packages\Finance\PaymentType;

class CreditService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data):? int
    {
        return Credit::create($data)->calc_id;
    }

    /**
     * @param int $id
     * @return ResponseData|null
     */
    public function calculate(int $id):? ResponseData
    {
        $credit = Credit::findOrFail($id);
        $data   = $credit;
        $credit->delete();

        return
            Manager::check(
                Manager::setCredit(
                    $data->title, $data->amount, $data->percent, $data->period, $data->payment
                )
            );
    }

}
