<?php

namespace App\Item\Order\Payment;

use App\Item\Order;

abstract class Model
{
    protected static string $name = '';
    protected static string $code = '';
    protected static string $description = '';
    protected static string $img = '';

    public function getName(): string
    {
        return static::$name;
    }

    public function getCode(): string
    {
        return static::$code;
    }

    public function getDescription(): string
    {
        return static::$description;
    }

    public function getImg(): string
    {
        return static::$img;
    }

    public static function getPaymentLink(Order $order): string
    {
        return "";
    }
}