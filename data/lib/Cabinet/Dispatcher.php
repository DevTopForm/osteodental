<?php

namespace App\Cabinet;

use Exception;

class Dispatcher
{
    private array $controllers = [];

    /**
     * @throws Exception
     */
    public function dispatch($path)
    {
        if (empty($this->controllers)) {
            throw new Exception('Can`t dispatch. Have no controllers');
        }

        foreach ($this->controllers as $controller) {
            if ($controller->isDispatchable($path)) {
                $controller->setPath($path);
                return $controller;
            }
        }

        throw new Exception('Can`t dispatch. Cant find appropriate controller');
    }

    public function registerController(Controller $controller): void
    {
        $this->controllers[] = $controller;
    }
}