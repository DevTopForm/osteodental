<?php

namespace App\Node;

use App\Model;
use App\Node;
use App\Registry;
use App\Searcher;

class History extends Model
{
    public $id;
    protected $table;

    public function __construct($table, $id)
    {
        $this->table = $table;
        $this->id = $id;
    }

    public function getItem()
    {
        $parameters['filters'] = [
            'element_id=' . $this->id
        ];
        $searcher = self::prepareSearcher($parameters, null);
        $recordSet = $searcher->search();
        $items = $recordSet->getItems();
        $this->prepareItem(array_shift($items));
    }

    public static function prepareSearcher($parameters, $limiter)
    {
        $settings = Registry::get('settings');
        $searcher = new Searcher();
        $searcher->setTable(self::getVar('historyTable'));
        if (empty($parameters['sorters'])) {
            $parameters['sorters'] = array(
                sprintf(
                    '%s %s',
                    self::getVar('defaultSorter'),
                    self::getVar('defaultOrder')
                )
            );
        }
        $searcher->noPager();
        $searcher->applySearchParameters($parameters);
        return $searcher;
    }

    protected function prepareItem($item)
    {
        $data = json_decode($item['data'], true);
        foreach ($data as $fieldName => $fieldValue) {
            if ($fieldName == 'node') {
                $fieldValue = new Node($fieldValue);
            }
            $this->$fieldName = $fieldValue;
        }
    }

    public function setFields($fields)
    {
        foreach ($fields as $field) {
            $name = $field->name;
            if (isset($this->$name)) {
                $field->setValue($this->$name);
            }
            $this->nodes_fields[] = $field;
        }
    }

    protected function getData()
    {
        $data = array(
            'node' => $this->node->id,
        );
        foreach ($this->nodes_fields as $key => $field) {
            $data[$field->name] = $field->getValue();
        }
        return $data;
    }
}