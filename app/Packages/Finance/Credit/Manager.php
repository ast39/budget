<?php

namespace App\Packages\Finance\Credit;

use App\Packages\Finance\Exceptions\RequestDataException;
use App\Packages\Finance\Exceptions\ResponseDataException;
use App\Packages\Finance\DetailsTrait;
use App\Packages\Finance\PaymentType;

/**
 * Фасад кредитов
 */
class Manager {

    use DetailsTrait;

    /**
     * Получить объект кредитного запроса
     *
     * @param string $title
     * @param int $payment_type
     * @param int|null $start_date
     * @param int|null $payment_date
     * @param string|null $subject
     * @param float|null $amount
     * @param float|null $percent
     * @param int|null $period
     * @param float|null $payment
     * @param array|null $payments
     * @return RequestData|string
     */
    public static function setCredit(
        string   $title,
        int      $payment_type,
        ?int     $start_date,
        ?int     $payment_date,
        ?string  $subject,
        ?float   $amount,
        ?float   $percent,
        ?int     $period,
        ?float   $payment,
        ?array   $payments,
    ): RequestData|string
    {
        try {
            return new RequestData($title, $payment_type, $start_date, $payment_date, $subject, $amount, $percent, $period, $payment, $payments);
        } catch (RequestDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать сумму кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     * @throws ResponseDataException
     */
    public static function findAmount(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $credit->amount = $creditObj->getAmount($credit);

            if ($credit->payment_type == PaymentType::DIFFERENCE) {
                $details = self::monthlyStatementDiff($credit);
            } else {
                $details = self::monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );
        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать процент кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public static function findPercent(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $credit->percent = $creditObj->getPercent($credit);

            if ($credit->payment_type == PaymentType::DIFFERENCE) {
                $details = self::monthlyStatementDiff($credit);
            } else {
                $details = self::monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать срок кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public static function findPeriod(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $credit->period = $creditObj->getPeriod($credit);

            if ($credit->payment_type == PaymentType::DIFFERENCE) {
                $details = self::monthlyStatementDiff($credit);
            } else {
                $details = self::monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать ежемесячный платеж
     *
     * @param RequestData $credit
     * @return ResponseData|string
     * @throws RequestDataException
     */
    public static function findPayment(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            if ($credit->amount <= 0) {
                throw new RequestDataException('Amount can\'t be lower or zero', 901);
            }

            if ($credit->percent <= 0) {
                throw new RequestDataException('Percent can\'t be lower or zero', 902);
            }

            if ($credit->period <= 0) {
                throw new RequestDataException('Period can\'t be lower or zero', 903);
            }

            if ($credit->payment_type == PaymentType::DIFFERENCE) {

                $credit->payment = round($credit->amount / $credit->period, 2);
                $details         = self::monthlyStatementDiff($credit);
            } else {

                $credit->payment = $creditObj->getPayment();
                $details         = self::monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Вернуть объект кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public static function data(RequestData $credit): ResponseData|string
    {
        try {
            $details  = self::monthlyStatement($credit);

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }
}
