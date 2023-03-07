<?php

namespace App\Services\Calculate;

use App\Models\Calculate\Credit;
use App\Packages\Finance\Credit\Manager;
use App\Packages\Finance\Credit\ResponseData;
use App\Packages\Finance\CreditSubject;
use App\Packages\Finance\Exceptions\RequestDataException;
use App\Packages\Finance\Exceptions\ResponseDataException;

class CreditService {

    /**
     * @param $data
     * @return int|null
     */
    public function store($data):? int
    {
        return Credit::create($data)->credit_id;
    }

    /**
     * @param int $id
     * @return ResponseData|null
     * @throws RequestDataException|ResponseDataException
     */
    public function calculate(int $id):? ResponseData
    {
        $credit = Credit::findOrFail($id);
        $data   = $credit;
        $credit->delete();

        $credit = Manager::setCredit(
            $data->title,
            $data->payment_type,
            null,
            null,
            $data->subject,
            $data->amount,
            $data->percent,
            $data->period,
            $data->payment,
            null
        );

        return match($data['subject']) {

            CreditSubject::AMOUNT  => Manager::findAmount($credit),
            CreditSubject::PERCENT => Manager::findPercent($credit),
            CreditSubject::PERIOD  => Manager::findPeriod($credit),

            default   => Manager::findPayment($credit),
        };
    }

}
