<?php

namespace App\Packages\Finance\Deposit;

use App\Packages\Finance\DetailsTrait;
use App\Packages\Finance\Exceptions\RequestDataException;
use App\Packages\Finance\Exceptions\ResponseDataException;

/**
 * Фасад вкладов
 */
class Manager {

    use DetailsTrait;

    /**
     * @param string $title
     * @param float $amount
     * @param float $percent
     * @param int $period
     * @param float $refill
     * @param int $plow_back
     * @param bool $withdrawal
     * @param int|null $start_date
     * @param int|null $deposit_id
     * @return RequestData|string
     */
    public static function setDeposit(
        string $title,
        float  $amount,
        float  $percent,
        int    $period,
        float  $refill,
        int    $plow_back,
        bool   $withdrawal,
        ?int   $start_date = null,
        ?int   $deposit_id = null,
    ): RequestData|string
    {
        try {
            return new RequestData($title, $amount, $percent, $period, $refill, $plow_back, $withdrawal, $start_date, $deposit_id);
        } catch (RequestDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * @param RequestData $deposit
     * @return ResponseData|string
     */
    public static function calculate(RequestData $deposit): ResponseData|string
    {
        try {
            $depositObj = new Core($deposit);

            $current_deposit = $deposit->amount;
            $total_profit    = 0;
            $current_year    = date('Y', $deposit->start_date);
            $current_month   = date('m', $deposit->start_date);

            $details = [];

            for ($i = 1; $i <= $deposit->period; $i++) {

                $inset_balance    = $current_deposit;
                $monthly_profit   = $depositObj->getMonthlyProfit($current_year, $current_month, $inset_balance);
                $monthly_deposit  = $depositObj->getMonthlyDeposit($monthly_profit, $i == $deposit->period);
                $outset_balance   = $inset_balance + $monthly_deposit;

                $total_profit    += $monthly_profit;
                $current_deposit += $monthly_deposit;

                $details[] = [

                    'date_time'       => self::getMonth($deposit->start_date, $i),
                    'inset_balance'   => round($inset_balance, 2),
                    'monthly_profit'  => round($monthly_profit, 2),
                    'monthly_refill'  => round($i == $deposit->period ? 0 : $deposit->refill, 2),
                    'monthly_deposit' => round($monthly_deposit, 2),
                    'total_profit'    => round($total_profit, 2),
                    'outset_balance'  => round($outset_balance, 2),
                    'was_withdrawn'   => round($deposit->withdrawal == 1 ? $total_profit   : 0, 2),
                    'withdrawal_now'  => round($outset_balance, 2),
                ];

                $current_year++;
                $current_month++;
                $current_month = $current_month == 13 ? 1 : $current_month;
            }

            return new ResponseData(
                $deposit,
                $total_profit,
                $details
            );
        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }
}
