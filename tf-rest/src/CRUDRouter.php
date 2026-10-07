<?php

namespace TFRest;

abstract class CRUDRouter extends Router
{
    public function route(): Response
    {
        $controller = new $this->controllerClass;

        return match ($_SERVER['REQUEST_METHOD']) {
            "POST" => call_user_func([$controller, "createAction"], $this->urlParts),
            "PUT", "PATCH" => call_user_func([$controller, "updateAction"], $this->urlParts),
            "DELETE" => call_user_func([$controller, "deleteAction"], $this->urlParts),
            default => call_user_func([$controller, "indexAction"], $this->urlParts),
        };
    }
}