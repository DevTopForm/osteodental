<?php

namespace App\Admin\Page;

use App\File;
use App\Item\Feedback;
use App\Item\Order;
use App\Item\Order\Status;
use App\Item\Widget as ItemWidget;
use App\Query;

class Index extends Model
{
    protected $action = "index";
    protected $localTpl = 'content/index.tpl';

    protected function parseContent()
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('widgets', $this->getWidgets());
        return $tpl->fetch($this->localTpl);
    }

    private function getWidgets(): array
    {
        $result = ItemWidget::getList(['filters' => ['public = 1'], 'sorters' => ['sorter ASC'], NULL])->getItems();

        if(empty($result)){
            return [];
        }

        foreach ($result as $key => $value){
            if(empty($value->widget)){
                unset($result[$key]);
            }
        }

        return $result;
    }
}