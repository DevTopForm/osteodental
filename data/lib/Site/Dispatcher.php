<?php

namespace App\Site;

class Dispatcher
{
    private $controllers = array();

    public function dispatch($path)
    {
        if (empty($this->controllers)) {
            throw new \Exception('Can`t dispatch. Have no controllers');
        }

        foreach ($this->controllers as $controller) {
            if ($controller->isDispatchable($path)) {
                $controller->setPath($path);
                return $controller;
            }
        }

        throw new \Exception('Can`t dispatch. Cant find appropriate controller');
    }

    public function registerController(Controller $controller)
    {
        array_push($this->controllers, $controller);
    }
}