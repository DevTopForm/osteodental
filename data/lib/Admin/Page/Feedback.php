<?php

namespace App\Admin\Page;

use App\Item\History as ItemHistory;
use App\Query;
use App\Utils;
use App\Item\Feedback as ItemFeedback;

class Feedback extends LAVED
{

    protected $localTpl = 'content/feedback.tpl';
    protected $action = 'feedback';

    protected function setItemFields()
    {
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_LIST) {
            $this->updateList();
        }
    }

    protected function updateList()
    {
        ItemHistory::add("Входящие сообщения", "/adm/feedback");
        if (isset(Query::$post['remove']) && !empty(Query::$post['remove']) && isset(Query::$post['list'])) {
            foreach (Query::$post['list'] as $item_id => $item) {
                if (isset($item)) {
                    $comment = new ItemFeedback($item_id);
                    $comment->delete();
                }
            }
            Utils::redirect($this->pathPrefix);
        }
        if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
            foreach (Query::$post['list'] as $item_id => $item) {
                if (isset($item)) {
                    $comment = new ItemFeedback($item_id);
                    $comment->public = 1;
                    $comment->save();
                }
            }
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function getItem()
    {
        return new ItemFeedback($this->extractItemId());
    }

    protected function getItemsList()
    {
        return ItemFeedback::getList($this->getParameters(), 20);
    }
}