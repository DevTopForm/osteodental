<?php

namespace App\Admin\Page;

use App\Admin\Action;
use App\Admin\LoginManager;
use App\Admin\Page;
use App\Item\Comment;
use App\Item\Feedback;
use App\Item\Order;
use App\Structure;
use App\Utils;

abstract class Model extends Page
{

    protected $user;
    protected $action = '';

    protected function checkPageAccess()
    {
        if (!empty($this->action)) {
            return $this->user->hasAccess($this->action);
        }
        return true;
    }

    public function init()
    {
        parent::init();
        $this->user = $this->getUser();
        if (!$this->checkPageAccess()) {
            Utils::redirect($this->admPath . '/denied');
        }
    }

    protected function getParsedBlocks()
    {
        (empty($this->node)) ? $node = [] : $node = $this->node;
        return [
            'color' => $this->setColor(),
            'content' => $this->parseContent(),
            'user' => $this->parseUserInfo(),
            'tree' => $this->parseNodesTree(),
            'main_menu' => $this->parseMainMenu(),
            'node' => $node,
            'isContent' => $this instanceof Content
        ];
    }

    protected function setColor()
    {
        $include = '';
        if (!empty($_COOKIE['theme_color'])) {
            $include = $_COOKIE['theme_color'] . '.css';
        }
        return $include;
    }

    protected function parseMainMenu()
    {
        $tpl = $this->getTpl();
        $this->menu = Action::getTree();
        if (!empty($this->menu)) {
            $menu = $this->prepareMenu($this->menu);
            $tpl->assign('menu', $menu);

            if ($this instanceof Content) {
                $tpl->assign('content', true);
            }
        }

        return $tpl->fetch('menu/main-menu.tpl');
    }

    protected function prepareMenu($list)
    {
        $menu = [];
        foreach ($list as $item) {
            if (empty($item->menu)) {
                continue;
            }
            if (!$this->user->hasAccess($item->action)) {
                continue;
            }
            if ($item->action == $this->action) {
                $item->active = true;
            }
            if (!empty($item->info)) {
                $item->infodata = $this->getMenuInfo($item->action);
            }
            if (!empty($item->childs)) {
                $item->childs = $this->prepareMenu($item->childs);
            }
            $menu[] = $item;
        }
        //var_dump($menu);
        return $menu;
    }

    protected function parseNodesTree()
    {
        return Structure::get_instance()->get_tree();
    }

    protected function parseUserInfo()
    {
        return $this->user;
    }

    protected function parseContent()
    {
        return 'Content of: ' . get_class($this);
    }

    protected function getUser()
    {
        try {
            return LoginManager::getLoggedUser();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    protected function getTpl()
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('user', $this->user);
        return $tpl;
    }

    protected function getMenuInfo($key)
    {
        try {
            switch ($key) {
                case 'comment':
                    return Comment::getList(['filters' => ['public = 0']])->getTotal();
                case 'feedback':
                    return Feedback::getList(['filters' => ['public = 0']])->getTotal();
                case 'order':
                    return Order::getList(['filters' => ['status = 1']])->getTotal();
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
