<?php

namespace App\Admin\Page;

use App\Node\Field\Item;
use App\Node\Setting\Field\Item as SettingItem;
use App\Query;
use App\Utils;

class Modparam extends ModLAVED
{

    protected $localTpl = 'content/modparam.tpl';

    private $_fields = [
        'title' => [
            'type' => 'text',
            'title' => 'Наименование'
        ],
        'name' => [
            'type' => 'text',
            'title' => 'Имя в таблице'
        ],
        'field' => [
            'type' => 'select',
            'title' => 'Тип поля',
            'data' => [],
        ],
        'editor' => [
            'type' => 'checkbox',
            'title' => 'Текстовый редактор',
        ],
        'example' => [
            'type' => 'text',
            'title' => 'Комментарий к полю'
        ],
        'format' => [
            'type' => 'text',
            'title' => 'Формат данных (format)'
        ],
        'prepare' => [
            'type' => 'text',
            'title' => 'Фукция обработки (prepare)'
        ],
        'table_data' => [
            'type' => 'text',
            'title' => 'Таблица с данными (table_data)'
        ],
        'table_filter' => [
            'type' => 'table_filters',
            'title' => 'Фильтр таблицы'
        ],
        'edit_in_node' => [
            'type' => 'checkbox',
            'title' => 'Редактируется в разделе',
        ],
        'local' => [
            'type' => 'checkbox',
            'title' => 'Редактируется в блоке',
        ],
        'advanced' => [
            'type' => 'checkbox',
            'title' => 'Специальное',
        ],
    ];

    protected function setItemFields()
    {
        $this->item->oldname = empty($this->item->name) ? '' : $this->item->name;
        $this->item->type = $this->module->type;
        $this->item->title = strip_tags(Query::$post['title']);
        $this->item->name = Utils::translit(strip_tags(Query::$post['name']));
        $this->item->field = strip_tags(Query::$post['field']);
        $this->item->table_data = strip_tags(Query::$post['table_data']);
        $this->item->format = strip_tags(Query::$post['format']);
        $this->item->example = Query::$post['example'];
        $this->item->prepare = strip_tags(Query::$post['prepare']);
        $this->item->required = empty(Query::$post['required']) ? 0 : 1;
        $this->item->local = empty(Query::$post['local']) ? 0 : 1;
        $this->item->edit_in_node = empty(Query::$post['edit_in_node']) ? 0 : 1;
        $this->item->advanced = empty(Query::$post['advanced']) ? 0 : 1;
        $this->item->editor = empty(Query::$post['editor']) ? 0 : 1;
        if (!empty(Query::$post['table_filter'])) {
            $this->item->table_filter = array();
            foreach (Query::$post['table_filter']['field'] as $key => $field) {
                if (!empty($field)) {
                    $this->item->table_filter[] = array(
                        'field' => $field,
                        'operation' => Query::$post['table_filter']['operation'][$key],
                        'value' => Query::$post['table_filter']['value'][$key],
                    );
                }
            }
        } else {
            $this->item->table_filter = array();
        }
    }

    protected function getItem()
    {
        return new SettingItem($this->extractItemId());
    }

    protected function getItemsList()
    {
        return SettingItem::getList($this->getParameters());
    }

    protected function getSpecialEditData()
    {
        $this->_fields['field']['data'] = array_map(function($element){
            return (object)[
                'id' => $element,
                'title' => $element,
            ];
        }, array_keys(Item::$types));

        return [
            'fields' => $this->_fields
        ];
    }
}