<?php

namespace App\Control\Pager;

use App\Admin\Template as AdminTemplate;
use App\Control\Pager;
use App\Template;

class Zero extends Pager
{

    public function isNull()
    {
        return true;
    }

    public function bindWith()
    {
    }

    function getHtml($admin = false)
    {
        if ($admin) {
            $tpl = new AdminTemplate();
        } else {
            $tpl = new Template();
        }
        $data = [
            'pages' => 0,
        ];
        $tpl->assign('pager', $data);
        $tpl->assign('filter', $this->getBindedParamsQueryString());
        return $tpl->fetch('filters/pager.tpl');
    }
}
