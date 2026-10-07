<?php

namespace TFRest\Service;

use TFRest\Service;

class Order extends Service
{
    protected string $repositoryClass = \TFRest\Repository\Order::class;
}