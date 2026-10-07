<?php

namespace TFRest\Router;

use TFRest\CRUDRouter;

class CaseRouter extends CRUDRouter {
    protected string $controllerClass = \TFRest\Controller\CaseController::class;
}
