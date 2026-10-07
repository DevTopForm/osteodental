<?php

namespace App\Admin\Page;

use App\Node\Type\Template;
use App\Query;
use App\Utils;

class Modtpl extends ModLAVED{

	protected $localTpl = 'content/modtpl.tpl';

    private $_fields = [
        'title' => [
            'type' => 'text',
            'title' => 'Наименование'
        ],
        'file' => [
            'type' => 'text',
            'title' => 'Наименование файла'
        ],
        'in_block' => [
            'type' => 'checkbox',
            'title' => 'Доступен в блоке'
        ]
    ];

	protected function setItemFields(){
		$this->item->type = $this->module->type;
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->file = strip_tags(Query::$post['file']);
		$this->item->in_block = empty(Query::$post['in_block']) ? 0 : 1;
	}

	protected function afterSaveItem(){
		Utils::redirect($this->pathPrefix.'/list/'.$this->module->id);
	}

	protected function afterDeleteItem(){
		Utils::redirect($this->pathPrefix.'/list/'.$this->module->id);
	}

	protected function getItem(){
		return new Template($this->extractItemId());
	}

	protected function getItemsList(){
		return Template::getList($this->getParameters());
	}

    protected function getSpecialEditData()
    {
        return [
            'fields' => $this->_fields
        ];
    }
}