<?php

namespace App\Classes;

class Icons {

    const TITLE          = 'bi bi-text-indent-left';
    const BANK           = 'bi bi-bank';
    const TYPE           = 'bi bi-list';
    const CATEGORY       = 'bi bi-list-ul';

    const AMOUNT         = 'bi bi-collection';
    const PERCENT        = 'bi bi-percent';
    const PERIOD         = 'bi bi-clock-history';
    const PAYMENT        = 'bi bi-cash-stack';

    const CALENDAR_MONTH = 'bi bi-calendar3';
    const CALENDAR_DAY   = 'bi bi-calendar2-date';

    const CASH           = 'bi bi-currency-exchange';
    const BALANCE        = 'bi bi-coin';
    const CHECK_LIST     = 'bi bi-card-checklist';
    const CHECKED        = 'bi bi-check2-all';
    const NOTE           = 'bi bi-card-text';
    const CAPITALIZATION = 'bi bi-cash-coin';
    const WITHDRAWAL     = 'bi bi-arrow-counterclockwise';
    const COUNTER        = 'bi bi-123';
    const TRANSACTIONS   = 'bi bi-arrow-down-up';
    const WALLET         = 'bi bi-wallet2';
    const LIST           = 'bi bi-list-ol';

    const PROFIT         = 'bi bi-chevron-double-up';
    const LOSS           = 'bi bi-chevron-double-down';
    const TOOLS          = 'bi bi-tools';
    const QUESTION       = 'bi bi-question-circle';

    const PAYING         = 'bi bi-hourglass-top';
    const WAS_PAYED      = 'bi-hourglass-split';
    const WILL_PAY       = 'bi bi-hourglass-bottom';

    const SMILE_HAPPY    = 'bi bi-emoji-smile';
    const SMILE_NEUTRAL  = 'bi bi-emoji-neutral';
    const SMILE_SAD      = 'bi bi-emoji-frown';

    const PAYMENT_CHECK   = 'bi bi-check2-square';
    const PAYMENT_OVERDUE = 'bi bi-exclamation-triangle';
    const PAYMENT_WAITING = 'bi bi-stopwatch';

    /**
     * @param string $class
     * @return string
     */
    public static function get(string $class): string
    {
        return '<i class="' . $class . '"></i>';
    }

}
