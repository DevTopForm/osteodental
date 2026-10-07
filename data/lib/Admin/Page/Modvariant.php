<?php

namespace App\Admin\Page;

use App\Node\Type;
use App\Node\Variant\Item;
use App\Query;
use App\Utils;

class Modvariant extends Modfield
{

    protected $localTpl = 'content/modvariant.tpl';

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
        $this->item->oldname = empty($this->item->name) ? '' : $this->item->name;
        $this->item->type = $this->module->type;
        $this->item->title = strip_tags(Query::$post['title']);
        $this->item->name = Utils::translit(strip_tags(Query::$post['name']));
        $this->item->field = strip_tags(Query::$post['field']);
        $this->item->table_data = strip_tags(Query::$post['table_data']);
        $this->item->table_value = strip_tags(Query::$post['table_value']);
        $this->item->table_filter = strip_tags(Query::$post['table_filter']);
        $this->item->format = strip_tags(Query::$post['format']);
        $this->item->example = Query::$post['example'];
        $this->item->prepare = strip_tags(Query::$post['prepare']);
        $this->item->required = empty(Query::$post['required']) ? 0 : 1;
        $this->item->show = empty(Query::$post['show']) ? 0 : 1;
        $this->item->advanced = empty(Query::$post['advanced']) ? 0 : 1;
        $this->item->editor = empty(Query::$post['editor']) ? 0 : 1;
        $this->item->search = empty(Query::$post['search']) ? 0 : 1;
        $this->item->filter_show = empty(Query::$post['filter_show']) ? 0 : 1;
        $this->item->property_show = empty(Query::$post['property_show']) ? 0 : 1;
        $this->item->property_list_show = empty(Query::$post['property_list_show']) ? 0 : 1;
        $this->item->property_list_show_mobile = empty(Query::$post['property_list_show_mobile']) ? 0 : 1;
    }

    protected function getItem()
    {
        return new Item($this->extractItemId());
    }

    protected function getItemsList()
    {
        return Item::getList($this->getParameters());
    }

    protected function getSpecialEditData()
    {
        return [
            'types' => Item::$types,
        ];
    }

}
