<?php

namespace App\Admin\Page;

use App\Item\History as ItemHistory;
use App\Node\Field\Item;
use App\Node\Field\Complex;
use App\Node\Catalog\Field\Item as CatalogItem;
use App\Node\Group;
use App\Node\Type;
use App\Query;
use App\Utils;

class Modfield extends ModLAVED
{
    const STATE_LIST_COMPLEX = 'listcomplex';
    const STATE_ADD_COMPLEX = 'addcomplex';
    const STATE_EDIT_COMPLEX = 'editcomplex';
    const STATE_DELETE_COMPLEX = 'deletecomplex';

    protected $localTpl = 'content/modfield.tpl';

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
            'data' => []
        ],
        'editor' => [
            'type' => 'checkbox',
            'title' => 'Текстовый редактор'
        ],
        'node_group' => [
            'type' => 'select',
            'title' => 'Группа',
            'data' => []
        ],
        'example' => [
            'type' => 'text',
            'title' => 'Пример'
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
            'type' => 'text',
            'title' => 'Поле фильтрации (table_filter)'
        ],
        'table_value' => [
            'type' => 'text',
            'title' => 'Значение фильтра (table_value)'
        ],
        'show' => [
            'type' => 'checkbox',
            'title' => 'Показывать в списке'
        ],
        'required' => [
            'type' => 'checkbox',
            'title' => 'Обязательное поле'
        ],
        'sorter' => [
            'type' => 'checkbox',
            'title' => 'Сортировать по этому полю'
        ],
        'search' => [
            'type' => 'checkbox',
            'title' => 'Поиск по этому полю'
        ],
        'filter_show' => [
            'type' => 'checkbox',
            'title' => 'Отображать в фильтре'
        ],
        'property_show' => [
            'type' => 'checkbox',
            'title' => 'Отображать в характеристиках'
        ],
        'property_list_show' => [
            'type' => 'checkbox',
            'title' => 'Отображать в списке товаров'
        ],
        'property_list_show_mobile' => [
            'type' => 'checkbox',
            'title' => 'Отображать в списке товаров (мобильная версия)'
        ],
    ];

    protected function getStateRegexps()
    {
        return [
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_ADD => '/^add\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+\/\d+$/i',
            self::STATE_LIST_COMPLEX => '/^list\/\d+\/\d+$/i',
            self::STATE_ADD_COMPLEX => '/^add\/\d+\/\d+$/i',
            self::STATE_EDIT_COMPLEX => '/^edit\/\d+\/\d+\/\d+$/i',
            self::STATE_DELETE_COMPLEX => '/^delete\/\d+\/\d+\/\d+$/i',
        ];
    }

    protected function executeRequestProcessing()
    {
        $this->module = new Type(@intval($this->parts[3]));
        if (empty($this->module->has_content)) {
            Utils::redirect($this->admPath . '/module');
        }
        if ($this->state == self::STATE_ADD_COMPLEX || $this->state == self::STATE_EDIT_COMPLEX) {
            $this->editComplexItem();
        }
        if ($this->state == self::STATE_DELETE_COMPLEX) {
            $this->deleteComplexItem();
        }

        parent::executeRequestProcessing();
    }

    protected function deleteItem()
    {
        $this->item = $this->getItem();
        if (!empty($this->item->id)) {
            try {
                if ($this->item->field === "complex") {
                    $list = Complex::getList(["filters" => ["fid = " . $this->item->id]])->getItems();
                    foreach ($list ?: [] as $field) {
                        $field->delete();
                    }
                }

                $this->item->delete();
            } catch (\Exception $e) {
                return;
            }
        }
        $this->afterDeleteItem();
    }

    protected function parseStateListcomplex()
    {
        $this->item = $this->getItem();
        $tpl = $this->getItemsTpl();

        $subFieldsRs = (new Complex())->list(
            [
                'sorters' => [],
                'filters' => ["fid = " . $this->item->id]
            ]
        );

        if (!is_null($subFieldsRs)) {
            $tpl->assign('field', $this->item);
            $tpl->assign('module', $this->module);
            $tpl->assign('list', $subFieldsRs->getItems());
            $tpl->assign('total', $subFieldsRs->getTotal());
            $tpl->assign('filters', $this->getFiltersHtml());
            $subFieldsRs->getPager()->bindWith($this->filters);
            $tpl->assign('pager', $subFieldsRs->getPager()->getHTML(true));
            $tpl->assign('perpage', $subFieldsRs->getPager()->getPerPage());
        }
        return $tpl->fetch($this->localTpl);
    }

    protected function parseStateAddcomplex()
    {
        return $this->parseStateEditcomplex();
    }

    protected function parseStateEditcomplex()
    {
        $this->item = $this->getSubItem();
        $this->complex = $this->getItem();
        $tpl = $this->getItemsTpl();
        $tpl->assign('complex', $this->complex);
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('module', $this->module);
        $tpl->assign('data', $this->getSpecialEditData(["complex"]));
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function editComplexItem()
    {
        $this->item = $this->getSubItem();
        $this->complex = $this->getItem();
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        $this->item->fid = $this->complex->id;

        if ($this->item->validate()) {
            $this->item->save();
            $this->afterSaveItemComplex();
        }
    }

    protected function afterSaveItemComplex()
    {
        ItemHistory::add("Модули", "/adm/module");
        Utils::redirect($this->pathPrefix . '/list/' . $this->module->id . "/" . $this->complex->id);
    }

    protected function deleteComplexItem()
    {
        $this->item = $this->getSubItem();
        $this->complex = $this->getItem();
        if (!empty($this->item->id)) {
            try {
                $this->item->delete();
            } catch (\Exception $e) {
                return;
            }
        }
        $this->afterDeleteComplexItem();
    }

    protected function afterDeleteComplexItem()
    {
        ItemHistory::add("Модули", "/adm/module");
        Utils::redirect($this->pathPrefix . '/list/' . $this->module->id . "/" . $this->complex->id);
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
        $this->item->sorter = empty(Query::$post['sorter']) ? 0 : 1;
        $this->item->node_group = empty(Query::$post['node_group']) ? 0 : Query::$post['node_group'];
    }

    protected function getItem()
    {
        // creation/edit complex field
        if (Query::$post['field'] === "complex") {
            return new Item($this->extractItemId());
        } else {
            $field = new Item($this->extractItemId());
            if (!empty($this->module->is_catalog)) {
                // deleting complex field (it is instance of Item and has id, so return $field, else return usual catalog field)
                return $field->id ? $field : new CatalogItem($this->extractItemId());
            }
            return $field;
        }
    }

    protected function getSubItem()
    {
        return new Complex(@intval($this->parts[5]));
    }

    protected function getItemsList()
    {
        $fieldItem = !empty($this->module->is_catalog) ? new CatalogItem() : new Item();
        $fieldsRs = $fieldItem->list($this->getParameters());

        // Adding complex fields from nodes_fields table for catalog module
        if (!empty($this->module->is_catalog)) {
            $complexFields = (new Item())->list(
                [
                    'sorters' => [],
                    'filters' => ['type' => sprintf('type = "%s"', $this->module->type), 'field = "complex"']
                ]
            )->getItems();

            if (count($complexFields)) {
                $fieldsRs->setItems(array_merge($fieldsRs->getItems(), $complexFields));
            }
        }

        return $fieldsRs;
    }

    protected function getSpecialEditData($exceptionFieldKeys = [])
    {
        $fieldTypes = Item::$types;
        foreach ($exceptionFieldKeys as $key) {
            unset($fieldTypes[$key]);
        }

        $this->_fields['field']['data'] = array_map(function ($element) {
            return (object)[
                'id' => $element,
                'title' => $element,
            ];
        }, array_keys($fieldTypes));
        $this->_fields['node_group']['data'] = Group::getList(
            ['filters' => ['type' => sprintf('type = "%s"', $this->module->type)], 'sorters' => ['weight ASC']],
            null
        )->getItems();

        return [
            'fields' => $this->_fields
        ];
    }

}