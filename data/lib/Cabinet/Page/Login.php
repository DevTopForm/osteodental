<?php

namespace App\Cabinet\Page;

use App\Cabinet\LoginManager;
use App\Cabinet\Page;
use App\Query;
use Smarty\Exception;

class Login extends Page
{
    protected string $localTpl = 'cabinet/login.tpl';

    /**
     * @throws Exception
     */
    protected function parseContent(): string
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('query', Query::$request);

        if(!empty(Query::$get['login_error'])) {
            $tpl->assign('error', LoginManager::getErrorMessageByCode((int)Query::$get['login_error']));
        }

        return $tpl->fetch($this->localTpl);
    }
}
