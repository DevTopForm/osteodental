<?php

namespace TFRest\Router;

use TFRest\CRUDRouter;

class ServiceRouter extends CRUDRouter {
    protected string $controllerClass = \TFRest\Controller\ServiceController::class;
}
