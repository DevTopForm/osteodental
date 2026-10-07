<?php

namespace App\Item\Order\Payment;

class Yoomoney extends Model
{
    static string $name = 'ЮMoney';
    static string $code = 'yoomoney';
    static string $description = 'Оплата картами РФ';
    static string $img = 'youmoney.svg';
}