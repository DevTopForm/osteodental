<?php

namespace App\Cabinet\Page;

use App\Item;
use App\Query;
use App\Utils;

class Index extends Text
{
    protected string $localTpl = 'cabinet/index.tpl';

    protected function executeRequestProcessing(): void
    {
        Utils::redirect('/cabinet/profile');
        if (!empty(Query::$post)) {
            if (empty(Query::$post['subscribe'])) {
                $this->user->subscribe = [];
            } else {
                $this->user->subscribe = Query::$post['subscribe'];
            }
            $this->user->save();
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function parseStateText(): string
    {
        $tpl = $this->getTextTpl();
        $orders = Item\Order::getList(['filters' => ['user = ' . $this->user->id], 'sorters' => ['date DESC']],
            5)->getItems();
        $tpl->assign('orders', $orders);

        \App\Node\Item::$itemsTable = "content_list";
        $tpl->assign('subscribes', \App\Node\Item::getList(['filters' => ['node = 335']])->getItems());
        return $tpl->fetch($this->localTpl);
    }

}
