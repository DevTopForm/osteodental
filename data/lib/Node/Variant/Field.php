<?php

namespace App\Node\Variant;

use \App\Node\Field as NodeField;
use App\Registry;

class Field extends NodeField
{

    protected static $fields_table = 'nodes_variant_fields';
    protected static $option_table = 'nodes_variant_fields_options';

    protected static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public static function getList($type)
    {
        $db = Registry::get('db');
        $data = $db->query(
            sprintf(
                "
			SELECT *
			FROM `%s`
			WHERE `type` = '%s'
			ORDER BY `weight` ASC
		",
                static::getVar('fields_table'),
                $type
            ),
            []
        )->toArray();
        $fields = array();

        foreach ($data as $item) {
            $item = new static($item);
            $item->setVariant();
            $fields[] = $item;
        }
        return $fields;
    }

    public static function getFilterList($type)
    {
        $db = Registry::get('db');
        $data = $db->query(
            sprintf(
                "
			SELECT *
			FROM `%s`
			WHERE `type` = '%s' AND `filter_show` = '%d'
			ORDER BY `weight` ASC
		",
                static::getVar('fields_table'),
                $type,
                1
            ),
            []
        )->toArray();
        $fields = array();

        foreach ($data as $item) {
            $item = new static($item);
            $item->setVariant();
            $fields[] = $item;
        }
        return $fields;
    }

    public function prepareValues()
    {
        $arrayItemsField = [];
        $arrayFields = [];
        $values = [];
        $fieldName = $this->name;
        foreach ($this->items as $item) {
            foreach ($item->variants as $variant) {
                if (!empty($variant->$fieldName)) {
                    $arrayItemsField[] = $variant->$fieldName;
                }
            }
        }

        if (!empty($this->options_data)) {
            foreach ($this->options_data as $option) {
                if (array_search($option['id'], $arrayItemsField) !== false) {
                    $values[] = $option;
                }
            }
        } else {
            $arrayItemsField = array_unique($arrayItemsField);
            foreach ($arrayItemsField as $key => $field) {
                $values[] = [
                    'id' => $field,
                    'title' => $field,
                    'value' => $field
                ];
            }
        }
        return $values;
    }
}

?>
