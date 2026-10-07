<?php

namespace App\Item\Order\Payment;

class Robokassa extends Model
{
    static string $name = 'Robokassa';
    static string $code = 'robokassa';
    static string $description = 'Оплата картами по всему миру, включая РФ';
    static string $img = 'robokassa.svg';
}