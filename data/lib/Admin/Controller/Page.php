<?php

namespace App\Admin\Controller;

use App\Admin\Action;
use App\Admin\Controller;
use App\Admin\LoginManager;
use App\Admin\Page\Login;
use App\Utils;

class Page extends Controller
{

    public function isDispatchable($pathStr)
    {
        return true;
    }

    public function run()
    {

        try {
            $user = LoginManager::getLoggedUser();
        } catch (\Exception $e) {
            $path = $this->removePathPrefix(join('/', $this->path));
            $path = explode('/', $path);
            $page = new Login();
            $page->init();
            $page->setPathPrefix(SYS_ADMIN_PATH_PREFIX . '/' . reset($path));
            $page->admPath = SYS_ADMIN_PATH_PREFIX;
            $page->parts = $this->path;
            echo $page->run();
            exit();
        }


        $page = $this->getPage();
        echo $page->run();
    }

    private function getPage()
    {

        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        $pageName = $this->getPageName(reset($path));
        if (!class_exists($pageName)) {
            throw new \Exception(sprintf('Class %s didn`t exists', $pageName));
        }
        $page = new $pageName();
        $page->init();
        $page->setPathPrefix(SYS_ADMIN_PATH_PREFIX . '/' . reset($path));
        $page->parts = $this->path;
        return $page;
    }

    private function getPageName($section)
    {
        $this->preparePagesMap();
        if (empty($section)) {
            return 'App\\Admin\\Page\\' . ucfirst($this->pagesMap['index']->class);
        }
        if (!in_array($section, array_keys($this->pagesMap))) {
            Utils::redirect(SYS_ADMIN_PATH_PREFIX);
        }
        return 'App\\Admin\\Page\\' . ucfirst($this->pagesMap[$section]->class);
    }

    private function preparePagesMap()
    {
        $pagesMap = Action::getList()->getItems();
        $this->pagesMap = [];
        foreach ($pagesMap as $action) {
            if (empty($action->class)) {
                $action->class = $action->action;
            }
            $this->pagesMap[$action->action] = $action;
        }
    }
}