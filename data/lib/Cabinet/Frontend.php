<?php

namespace App\Cabinet;

use App\Cabinet\Controller\Ajax;
use App\Cabinet\Controller\Auth;
use App\Cabinet\Controller\Eventreg;
use App\Cabinet\Controller\Login;
use App\Cabinet\Controller\Merchant;
use App\Cabinet\Controller\Recovery;
use App\Cabinet\Controller\Register;
use Exception;

class Frontend
{
    protected Dispatcher $dispatcher;

    protected array $controllers = [
        Ajax::class,
        Eventreg::class,
        Merchant::class,
        Auth::class,
        Register::class,
        Recovery::class,
        Login::class,
        \App\Cabinet\Controller\Page::class
    ];

    public function run(): void
    {
        $this->preparePathPrefix();
        $this->initDispatcher();
        $this->prepareRequest();
        session_start();
        try {
            $controller = $this->dispatcher->dispatch($_REQUEST['q']);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $controller->run();
    }

    private function preparePathPrefix(): void
    {
        if ('' === trim(CABINET_PATH_PREFIX, '/')) {
            define('SYS_CABINET_PATH_PREFIX', '');
            return;
        }
        define('SYS_CABINET_PATH_PREFIX', '/' . trim(CABINET_PATH_PREFIX, '/'));
    }

    private function initDispatcher(): void
    {
        $this->dispatcher = new Dispatcher();
        foreach ($this->controllers as $controllerName) {
            try {
                $controller = $this->loadController($controllerName);
            } catch (Exception) {
                continue;
            }
            $this->dispatcher->registerController($controller);
        }
    }

    private function prepareRequest(): void
    {
        $_REQUEST['q'] = trim(@$_REQUEST['q'], '/');
    }

    /**
     * @throws Exception
     */
    private function loadController($controllerName)
    {
        if (!class_exists($controllerName)) {
            throw new Exception('Controller: ' . $controllerName . ' does not exists');
        }
        return new $controllerName();
    }
}
