<?php

namespace App\Admin\Page;

use App\Node\Group;
use App\Node\Type;
use App\Query;
use App\Utils;

class Modgroup extends ModLAVED
{

    protected $localTpl = 'content/modgroup.tpl';

    private $_fields = [
        'title' => [
            'type' => 'text',
            'title' => 'Наименование'
        ]
    ];

    protected function executeRequestProcessing()
    {
        $module = new Type(@intval($this->parts[3]));
        if (empty($module->has_content)) {
            Utils::redirect($this->admPath . '/module');
        }
        parent::executeRequestProcessing();
    }

    protected function setItemFields()
    {
        $this->item->type = $this->module->type;
        $this->item->title = strip_tags(Query::$post['title']);
        $this->item->weight = Query::$post['weight'];
    }

    protected function getItem()
    {
        return new Group($this->extractItemId());
    }

    protected function getItemsList()
    {
        return Group::getList($this->getParameters());
    }

    protected function getSpecialEditData()
    {
        return [
          'fields' => $this->_fields
        ];
    }

}