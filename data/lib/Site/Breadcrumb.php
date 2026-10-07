<?php

namespace App\Site;

use App\Template;

class Breadcrumb
{

    private static ?self $_instance = null;

    private array $list = [];

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
    }

    public function push($item)
    {
        array_push($this->list, $item);
    }

    public function setNode($current)
    {
        $list = [];
        $node = $current;
        do {
            if ($node->id !== 4114) {
                //if (!empty($node->public)){
                $list[] = [
                    'title' => empty($node->bread) ? $node->title : $node->bread,
                    'url' => $node->getUrl(),
                    'active' => ($node->id == $current->id)
                ];
            }
            //}
            $node = $node->getParentNode();
        } while ($node != null);

        $list[] = [
            'title' => "Главная",
            'url' => "/",
            'active' => false
        ];

        $list = array_reverse($list);
        foreach ($list as $item) {
            $this->push($item);
        }
    }

    public function setItem($item)
    {
        foreach ($this->list as $key => $i) {
            $this->list[$key]['active'] = false;
        }
        $this->push(['title' => $item->title, 'url' => $item->getUrl(), 'active' => true]);
    }

    public function get()
    {
        return $this->list;
    }

    public function parse()
    {
        $tpl = new Template();
        $tpl->assign('list', $this->list);
        return $tpl->fetch('service/breadcrumbs.tpl');
    }

}