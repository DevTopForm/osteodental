<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Cabinet\Page\Recovery as PageRecovery;
use Smarty\Exception;

class Recovery extends Controller
{
    public function isDispatchable($pathStr): bool
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^recovery(\/confirm)?(\/success)?(\/sended)?$/', $pathStr);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        $page = new PageRecovery();
        $page->init();
        $page->setPathPrefix(SYS_CABINET_PATH_PREFIX . '/' . reset($path));
        $page->parts = $this->path;
        $page->run();
    }
}