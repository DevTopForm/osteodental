<?php

namespace App\Admin\Page;

use App\Admin\LoginManager;
use App\Admin\Page;
use App\Query;

class Login extends Page
{

    protected $localTpl = 'content/login.tpl';

    protected function parseContent()
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('query', Query::$request);

        if(!empty(Query::$get['login_error'])) {
            $tpl->assign('error', LoginManager::getErrorInfo()[Query::$get['login_error']] ?? '');
        }

        return $tpl->fetch($this->localTpl);
    }
}