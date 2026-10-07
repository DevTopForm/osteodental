<?php

namespace App;

use App\Site\Controller\Ajax;
use App\Site\Controller\Basket;
use App\Site\Controller\Checkout;
use App\Site\Controller\Favorite;
use App\Site\Controller\Product;
use App\Site\Controller\Page;
use App\Site\Controller\Region;
use App\Site\Dispatcher;

class Frontend
{
    protected $dispatcher;

    protected $controllers = array(
        Ajax::class,
        Basket::class,
        Product::class,
        Checkout::class,
        'Favorite',
        Favorite::class,
        'Viewed',
        'Subscribe',
        'Voting',
        'Compare',
        'Deferrer',
        'Merchant',
        'Market',
        'Banner',
        'Download',
        'Push',
        Region::class,
        Page::class,
    );

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
        if ('' === trim(SITE_PATH_PREFIX, '/')) {
            define('SYS_SITE_PATH_PREFIX', '');
            return;
        }
        define('SYS_SITE_PATH_PREFIX', '/' . trim(SITE_PATH_PREFIX, '/'));
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
