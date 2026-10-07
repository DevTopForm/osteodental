<?php

namespace App\Admin\Page;

class Scripts extends LAVED
{

    protected $localTpl = 'content/scripts.tpl';
    protected $action = 'scripts';

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        $items = $this->getScriptsList();
        if (!is_null($items)) {
            $tpl->assign('list', $items);
            $tpl->assign('total', count($items));
        }
        return $tpl->fetch($this->localTpl);
    }

    protected function getScriptsList()
    {
        $dir = array_diff(scandir('cron'), ['.', '..']);
        $result = [];
        if (!empty($dir)) {
            foreach ($dir as $item) {
                $name = explode('.', $item);
                $result[$name[0]] = "/cron/" . $item;
            }
        }
        return $result;
    }
}
