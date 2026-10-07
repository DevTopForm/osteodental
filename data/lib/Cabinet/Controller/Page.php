<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Cabinet\Exception;
use App\Cabinet\LoginManager;
use App\Utils;

class Page extends Controller
{
    private array $pagesMap = [
        'index' => 'index',
        'profile' => 'profile',
        'orders' => 'orders',
        'favorite' => 'favorite',
        'experience' => 'experience',
        'subscribe' => 'subscribe',
        'page' => 'page',
        'basket' => 'basket',
        'sales' => 'sales',
        'payment' => 'payment',
        '404' => 'notFound',
        'denied' => 'denied',
    ];

    public function isDispatchable($pathStr): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        try {
            LoginManager::getLoggedUser();
        } catch (\Exception) {
            $path = $this->removePathPrefix(join('/', $this->path));
            $path = explode('/', $path);
            $page = new \App\Cabinet\Page\Login();
            $page->init();
            $page->setPathPrefix(SYS_CABINET_PATH_PREFIX . '/' . reset($path));
            $page->parts = $this->path;
            $page->run();
            exit();
        }
        $page = $this->getPage();
        echo $page->run();
    }

    /**
     * @throws Exception
     */
    private function getPage()
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);

        $pageName = $this->getPageName(reset($path));
        if (!class_exists($pageName)) {
            throw new Exception(sprintf('Class %s didn`t exists', $pageName));
        }
        $page = new $pageName();
        $page->init();
        $page->setPathPrefix(SYS_CABINET_PATH_PREFIX . '/' . reset($path));
        $page->parts = $this->path;
        return $page;
    }

    /**
     * @throws Exception
     */
    private function getPageName($section): string
    {
        if (empty($section)) {
            return 'App\\Cabinet\\Page\\' . ucfirst($this->pagesMap['index']);
        }
        if (!in_array($section, array_keys($this->pagesMap))) {
            Utils::redirect(SYS_CABINET_PATH_PREFIX);
            throw new Exception(sprintf('Page %s didn`t exists in pages map', $section));
        }
        return 'App\\Cabinet\\Page\\' . ucfirst($this->pagesMap[$section]);
    }
}
