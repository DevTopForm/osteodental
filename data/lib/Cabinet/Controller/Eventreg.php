<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Cabinet\Page\Register;
use Smarty\Exception;

class Eventreg extends Controller
{
    public function isDispatchable($pathStr): bool
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^register(\/confirm)?(\/success)?$/', $pathStr);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        $page = new Register();
        $page->init();
        $page->setPathPrefix(SYS_CABINET_PATH_PREFIX . '/' . reset($path));
        $page->parts = $this->path;
        $page->run();
    }
}