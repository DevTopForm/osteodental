<?php

namespace App\Admin;

use App\Admin\Controller\Page as ControllerPage;
use App\Admin\Controller\Login as ControllerLogin;
use App\Admin\Controller\Ajax as ControllerAjax;

class Frontend
{
    protected $dispatcher;

    protected $controllers = [
        ControllerAjax::class,
        ControllerLogin::class,
        ControllerPage::class,
    ];

    public function run()
    {
        $this->preparePathPrefix();
        $this->initDispatcher();
        $this->prepareRequest();
        session_start();
        try {
            $controller = $this->dispatcher->dispatch($_REQUEST['q']);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        $controller->run();
    }

    private function preparePathPrefix()
    {
        if ('' === trim(ADMIN_PATH_PREFIX, '/')) {
            define('SYS_ADMIN_PATH_PREFIX', '');
            return;
        }
        define('SYS_ADMIN_PATH_PREFIX', '/' . trim(ADMIN_PATH_PREFIX, '/'));
    }

    private function initDispatcher()
    {
        $this->dispatcher = new Dispatcher();
        foreach ($this->controllers as $controllerName) {
            try {
                $controller = $this->loadController($controllerName);
            } catch (\Exception $e) {
                continue;
            }
            $this->dispatcher->registerController($controller);
        }
    }

    private function prepareRequest()
    {
        $_REQUEST['q'] = trim(@$_REQUEST['q'], '/');
    }

    private function loadController($controllerName)
    {
        if (!class_exists($controllerName)) {
            throw new \Exception('Controller: ' . $controllerName . ' does not exists');
        }
        return new $controllerName();
    }
}
