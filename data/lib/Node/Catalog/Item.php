<?php

namespace App\Node\Catalog;

use App\Node;
use App\Node\Item as NodeItem;
use App\Registry;

class Item extends NodeItem
{
    public static $default_fields = [
        'title' => [
            "title" => "Наименование",
            "required" => 1,
            "editor" => 0,
            "field" => 'text',
        ],
        'alias' => [
            "title" => "Псевдоним",
            "required" => 0,
            "editor" => 0,
            "field" => 'alias',
        ],
        'image' => [
            "title" => "Изображение",
            "required" => 0,
            "editor" => 0,
            "field" => 'image',
        ],
        'text' => [
            "title" => "Текст",
            "required" => 0,
            "editor" => 1,
            "field" => 'textarea',
        ],
        'h1' => [
            "title" => "H1",
            "required" => 0,
            "editor" => 0,
            "field" => 'text',
        ],
        'meta_title' => [
            "title" => "Мета-заголовок",
            "required" => 0,
            "editor" => 0,
            "field" => 'text',
        ],
        'meta_description' => [
            "title" => "Мета-описание",
            "required" => 0,
            "editor" => 0,
            "field" => 'textarea',
        ],
        'meta_keywords' => [
            "title" => "Ключевые слова",
            "required" => 0,
            "editor" => 0,
            "field" => 'textarea',
        ],
        'sorter' => [
            "title" => "Сортировка",
            "required" => 0,
            "editor" => 0,
            "field" => 'hidden',
        ],
        'public' => [
            "title" => "Опубликовать",
            "required" => 0,
            "editor" => 0,
            "field" => 'checkbox',
        ],
        'properties' => [
            "title" => "Свойства",
            "required" => 0,
            "editor" => 0,
            "field" => 'properties',
        ]
    ];

    protected function getData()
    {
        $data = [
            'node' => $this->node->id,
            'properties' => []
        ];

        $catalogFields = array_column($this->node->getCatalogFields(), 'name');
        if (empty($this->nodes_fields)) {
            $this->setFields($this->node->getFields());
            $this->setFields($this->node->getCatalogFields());
        }

        foreach ($this->nodes_fields as $key => $field) {
            if ($field->name == 'properties') {
                continue;
            }

            if (in_array($field->name, $catalogFields)) {
                $data['properties'][$field->name] = $field->getValue();
            } else {
                $data[$field->name] = $field->getValue();
            }
        }

        $data['properties'] = json_encode($data['properties'], JSON_UNESCAPED_UNICODE);

        return $data;
    }

    protected function prepareData()
    {
        parent::prepareData();

        foreach (json_decode($this->properties, JSON_UNESCAPED_UNICODE) as $propertyKey => $propertyValue) {
            $this->$propertyKey = $propertyValue;
        }
    }

    public function simpleUpdate($fieldTitle, $value)
    {
        $requiredField = null;
        $fields = $this->node->getFields();
        $catalogFields = $this->node->getCatalogFields();

        foreach ($fields as $field) {
            if ($field->name === $fieldTitle) {
                $requiredField = $field;
                break;
            }
        }
        foreach ($catalogFields as $field) {
            if ($field->name === $fieldTitle) {
                $requiredField = $field;
                break;
            }
        }

        $db = Registry::get('db');

        if ($requiredField instanceof Node\Catalog\Field) {
            $properties = json_decode($this->properties, true);
            $properties[$requiredField->name] = $value;

            $update = $db->sql->update();
            $update->table($this->table);
            $update->set(["properties" => json_encode($properties, JSON_UNESCAPED_UNICODE)]);
            $update->where('id=' . $this->id);
            $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        } else {
            $update = $db->sql->update();
            $update->table($this->table);
            $update->set([$requiredField->name => $value]);
            $update->where('id=' . $this->id);
            $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        }
    }
}