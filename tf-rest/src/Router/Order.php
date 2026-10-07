<?php

namespace TFRest\Router;

use TFRest\CRUDRouter;

class Order extends CRUDRouter {
    protected string $controllerClass = \TFRest\Controller\Order::class;
}