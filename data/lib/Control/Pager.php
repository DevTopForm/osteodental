<?php

namespace App\Control;

use App\Query;
use App\Template;
use App\Admin\Template as AdminTemplate;

class Pager extends Element
{
    protected $total;
    protected $title;
    protected $filter;
    protected $perPage = 50;

    protected $section = 'pager';

    public function init($total, $title = '', $perPage = null, $filter = null)
    {
        $this->total = $total;
        $this->title = $title;
        $this->filter = $filter;

        if ($perPage) {
            $this->perPage = $perPage;
        }
    }

    public function isNull()
    {
        return false;
    }

    function getCurrentPage()
    {
        if (!empty(Query::$request['page'])) {
            $page = (int)Query::$request['page'];
            return $page > 0 ? $page : 1;
        } else {
            return 1;
        }
    }

    function getPerPage()
    {
        return $this->perPage;
    }

    function getFrom()
    {
        return ($this->getCurrentPage() - 1) * $this->perPage + 1;
    }

    function getTo()
    {
        return min($this->total, $this->getCurrentPage() * $this->perPage);
    }

    function getPages()
    {
        return (int)ceil($this->total / $this->perPage);
    }

    function getHtml($admin = false)
    {
        if ($admin) {
            $tpl = new AdminTemplate();
        } else {
            $tpl = new Template();
        }
        $data = [
            'title' => $this->title,
            'total' => $this->total,
            'page' => $this->getCurrentPage(),
            'pages' => $this->getPages(),
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
            'previousPage' => $this->getCurrentPage() - 1,
            'nextPage' => $this->getCurrentPage() + 1,
            'perPage' => $this->getPerPage(),
            'requestUrl' => $this->prepareUrl()
        ];
        $tpl->assign('pager', $data);
        $tpl->assign('filter', $this->getBindedParamsQueryString());
        return $tpl->fetch('filters/pager.tpl');
    }

    protected function prepareUrl()
    {
        $urlReady = 'http://';
        if (!empty($_SERVER['HTTP_HTTPS']) && $_SERVER['HTTP_HTTPS'] == 'on') {
            $urlReady = 'https://';
        }

        $urlReady .= $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];

        if (!empty(Query::$get['page'])) {
            unset(Query::$get['page']);
        }
        $urlReady .= '?';
        if (!empty(Query::$get)) {
            $get = Query::$get;

            if (!empty($get['url'])) {
                unset($get['url']);
            }

            foreach ($get as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $inValue) {
                        $urlReady .= $key . urlencode('[]') . '=' . $inValue . '&';
                    }
                } else {
                    $urlReady .= $key . '=' . $value . '&';
                }
            }
        }
        return $urlReady;
    }
}
