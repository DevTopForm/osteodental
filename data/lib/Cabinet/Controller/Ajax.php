<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Cabinet\LoginManager;
use Exception;

class Ajax extends Controller
{
    protected string $categoryTpl = 'cabinet/ajax/category.tpl';
    protected string $linkTpl = 'cabinet/ajax/link.tpl';

    public function isDispatchable($pathStr): bool
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match(
            '/^ajax\/.*$/',
            $pathStr
        );
    }

    public function run(): void
    {
        try {
            $this->user = LoginManager::getLoggedUser();
            $this->getContent();
        } catch (Exception $e) {
            echo '<div class="messages" style="text-align:center;"><p class="error message">Ошибка: ' . $e->getMessage(
                ) . '</p></div>';
            die;
        }
    }

    /**
     * @throws Exception
     */
    protected function getContent(): null
    {
        $path = $this->getPreparedPath();
        throw new Exception();
    }

    /**
     * @throws Exception
     */
    protected function getPreparedPath(): array
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        array_shift($path);
        if (empty($path)) {
            throw new Exception();
        }
        return $path;
    }
}