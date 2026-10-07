<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Utils;
use Exception;

class Auth extends Controller
{
    public function isDispatchable($pathStr): bool
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^auth\/.*$/', $pathStr);
    }

    public function run(): void
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        array_shift($path);
        $type = array_shift($path);
        try {
            $controller = 'App\\Cabinet\\Controller\\Auth\\' . ucfirst($type);
            if (class_exists($controller)) {
                $auth = new $controller();
                $auth->run();
                Utils::redirect(empty($_SESSION['last_page']) ? '/cabinet' : $_SESSION['last_page']);
            }
        } catch (Exception) {
            Utils::redirect('/cabinet/login/');
        }
    }
}