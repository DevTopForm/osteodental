<?php

namespace App\Item\Order;

use App\Item\Order\Payment\Model;
use App\Item\Order\Payment\Robokassa;
use App\Item\Order\Payment\Yoomoney;

final class Payment
{
    public static function getList(): array
    {
        return [
            Yoomoney::$code => new Yoomoney(),
            Robokassa::$code => new Robokassa(),
        ];
    }

    public static function getCurrent($code): Model
    {
        $items = Payment::getList();
        return $items[$code] ?? $items[array_key_first($items)];
    }
}