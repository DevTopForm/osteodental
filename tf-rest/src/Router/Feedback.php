<?php

namespace TFRest\Router;

use TFRest\CRUDRouter;

class Feedback extends CRUDRouter {
    protected string $controllerClass = \TFRest\Controller\Feedback::class;
}