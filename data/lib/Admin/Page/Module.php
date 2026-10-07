<?php

namespace App\Admin\Page;

use App\CacheManager;
use App\Node\Type;
use App\Query;
use App\Utils;
use App\Item\History as ItemHistory;

class Module extends LAVED
{
    protected $localTpl = 'content/module.tpl';
    protected $action = 'module';

    protected function getStateRegexps()
    {
        return parent::getStateRegexps();
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();

        CacheManager::clear_cache();
    }

    protected function setItemFields()
    {
        if (empty($this->item->type)) {
            $this->item->type = strtolower(Utils::translit(strip_tags(Query::$post['type'])));
        }
        $this->item->title = strip_tags(Query::$post['title']);
        if (empty($this->item->title)) {
            $this->item->title = $this->item->type;
        }
        $this->item->old_has_content = empty($this->item->has_content) ? 0 : 1;
        $this->item->has_content = empty(Query::$post['has_content']) ? 0 : 1;
        $this->item->old_has_items = empty($this->item->has_items) ? 0 : 1;
        $this->item->has_items = empty(Query::$post['has_items']) ? 0 : 1;
        $this->item->search = empty(Query::$post['search']) ? 0 : 1;
        $this->item->in_node = empty(Query::$post['in_node']) ? 0 : 1;
        $this->item->in_block = empty(Query::$post['in_block']) ? 0 : 1;
        $this->item->sortable = empty(Query::$post['sortable']) ? 0 : 1;
        $this->item->old_has_variants = empty($this->item->has_variants) ? 0 : 1;
        $this->item->has_variants = empty(Query::$post['has_variants']) ? 0 : 1;
        $this->item->has_filters = empty(Query::$post['has_filters']) ? 0 : 1;
        $this->item->is_catalog = empty(Query::$post['is_catalog']) ? 0 : 1;
    }

    protected function getItem()
    {
        return new Type($this->extractItemId());
    }

    protected function getItemsList()
    {
        return Type::getList($this->getParameters());
    }

    protected function prepareList($list)
    {
        return $list;
    }

    protected function getSpecialListData()
    {
        return [];
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Модули", "/adm/module");
        Utils::redirect($this->pathPrefix);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Модули", "/adm/module");
        Utils::redirect($this->pathPrefix);
    }
}
