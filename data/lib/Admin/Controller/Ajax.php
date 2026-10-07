<?php

namespace App\Admin\Controller;

use App\Admin\Controller;
use App\Admin\LoginManager;

class Ajax extends Controller
{

    public function isDispatchable($pathStr)
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match(
            '/^ajax\/.*$/',
            $pathStr
        );
    }

    public function run()
    {
        try {
            $this->user = LoginManager::getLoggedUser();
            $this->getContent();
        } catch (\Exception $e) {
            echo '<div class="messages" style="text-align:center;"><p class="error message">Ошибка: ' . $e->getMessage(
                ) . '</p></div>';
            die;
        }
    }

    protected function checkSelf()
    {
        $ref = $_SERVER['HTTP_REFERER'];
        $url = parse_url($ref);
        if ($url['host'] != $_SERVER['HTTP_HOST']) {
            throw new \Exception('Access denied');
        }
    }

    protected function getContent()
    {
        $path = $this->getPreparedPath();
        $classname = 'App\\Admin\\Controller\\Ajax\\' . ucfirst(array_shift($path));
        if (class_exists($classname)) {
            $action = new $classname();
            $action->path = $path;
            $action->run();
        } else {
            throw new \Exception('Bad ajax action');
        }
    }

    protected function getPreparedPath()
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        array_shift($path);
        if (empty($path)) {
            throw new \Exception();
        }
        return $path;
    }

}