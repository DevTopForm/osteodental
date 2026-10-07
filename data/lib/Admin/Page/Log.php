<?php

namespace App\Admin\Page;

use App\Admin\Log\SlowSQL;
use App\Item\Log as ItemLog;
use App\Query;
use App\Utils;
use App\Item\History as ItemHistory;

class Log extends LAVED {

    protected $localTpl = 'content/log.tpl';
    protected $defaultState = 'list';
    protected $action = "logs";

    const STATE_CLEAR = 'clear';

    protected function getStateRegexps()
    {
        $regexps = parent::getStateRegexps();
        $regexps[self::STATE_CLEAR] = '/^clear\/\d+$/i';

        return $regexps;
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();

        if ($this->state == self::STATE_CLEAR) {
            $this->clearItem();
        }
    }

    protected function clearItem()
    {
        SlowSQL::clear();
        ItemHistory::add("Логи", "/adm/logs");
        Utils::redirect($this->pathPrefix . "/edit/" . $this->getItem()->id);
    }

    protected function getItem(){
        return new ItemLog($this->extractItemId());
    }

    protected function getItemsList(){
        return ItemLog::getList($this->getParameters(),50);
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->getItem());
        return $tpl->fetch($this->localTpl);
    }

    protected function setItemFields()
    {
        $this->item->active = Query::$post['active'] ? 1 : 0;
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Логи", "/adm/logs");
        Utils::redirect($this->pathPrefix);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Логи", "/adm/logs");
        Utils::redirect($this->pathPrefix);
    }
}