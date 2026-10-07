<?php

namespace App\Admin\Page;

use App\Query;
use App\Node as AppNode;
use App\Structure;
use App\Utils;

class Inner extends LAVED
{

    protected $localTpl = 'content/inner.tpl';
    protected $action = 'node';

    protected function getStateRegexps()
    {
        return [
            self::STATE_EDIT => '/^edit\/\d+$/i',
        ];
    }

    protected function setItemFields()
    {
        $this->item->before_title = Query::$post['before_title'];
        $this->item->before_text = Query::$post['before_text'];
        $this->item->after_title = Query::$post['after_title'];
        $this->item->after_text = Query::$post['after_text'];
    }

    protected function getItem()
    {
        return new AppNode($this->extractItemId());
    }

    protected function getItemsList($archive = 0)
    {
        return AppNode::getList($this->getParameters(), 20);
    }

    protected function afterSaveItem()
    {
        Utils::redirect($this->pathPrefix . '/edit/' . $this->item->id);
    }

    protected function afterDeleteItem()
    {
        Utils::redirect($this->admPath);
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        $items = Structure::getInstance()->getTree();
        if (!is_null($items)) {
            $tpl->assign('list', $items);
        }
        return $tpl->fetch($this->localTpl);
    }

}