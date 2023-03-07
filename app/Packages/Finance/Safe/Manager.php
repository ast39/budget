<?php

namespace App\Packages\Finance\Safe;

use App\Packages\Finance\Exceptions\RequestDataException;
use App\Packages\Finance\Exceptions\ResponseDataException;

/**
 * Фасад сейфов
 */
class Manager {

    /**
     * Получить объект сейфа запроса
     *
     * @param string $title
     * @param float|null $amount
     * @param array|null $payments
     * @return RequestData|string
     */
    public static function setSafe(
        string   $title,
        ?float   $amount,
        ?array   $payments,
    ): RequestData|string
    {
        try {
            return new RequestData($title, $amount, $payments);
        } catch (RequestDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    public static function calculate(RequestData $safe): ResponseData|string
    {
        try {
            $safeObj = new Core($safe);

            $details = $safeObj->history();

            return new ResponseData(
                $safe,
                $details
            );
        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }
}
