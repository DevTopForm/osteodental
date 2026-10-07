<?php

namespace App\Form;

use App\Message;
use App\Query;
use App\Utils;

class Field
{

    protected $id;
    protected $name;
    protected $title;
    protected $format;
    protected $required;
    protected $weight;
    protected $sorter;
    protected $value;
    protected $default;
    protected $class;
    protected $disabled;
    protected $variant = false;

    // props for complex fields
    protected string $complex_field_title;
    protected int $complex_field_row_id;
    protected int $complex_field_prop_id;

    public $messages = [];

    protected $params = [];

    public function __construct($field)
    {
        if (!is_null($field)) {
            $this->name = $field->name;
            $this->format = $field->format;
            $this->title = $field->title;
            $this->required = $field->required;
            $this->disabled = empty($field->disabled) ? 0 : 1;
            $this->weight = $field->weight;
            $this->sorter = $field->sorter;
            $this->example = @$field->example;
            $this->default = $field->default;
            $this->advanced = @$field->advanced;
//            pre($this->field);
            $this->table_data = $field->table_data ?? '';
            $this->table_filter = $field->table_filter ?? '';
            $this->table_value = $field->table_value ?? '';
            /*if (!empty($this->default)){
                $this->value = $this->default;
            }*/
            if (empty($this->type)) {
                $this->type = $field->field;
            }
        }
    }

    public static function factory($field)
    {
        $class = 'App\\Form\\' . ucfirst($field->field);
        if (class_exists($class)) {
            return new $class($field);
        }
        throw new \Exception('Unknown form field type - ' . $field->field);
    }

    public function getHtml()
    {
        return $this->getHtmlInput();
    }

    public function getSpecialHtml()
    {
        return '';
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setComplexFieldProperties(string $title, int $rowId, int $propId): void
    {
        $this->complex_field_title = $title;
        $this->complex_field_row_id = $rowId;
        $this->complex_field_prop_id = $propId;
    }

    public function setVariant()
    {
        $this->variant = true;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTypeField()
    {
        return $this->type;
    }

    public function setParams($params = [])
    {
        $this->params = $params;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSpecValue()
    {
        return $this->value;
    }

    public function getInsertValue()
    {
        return $this->value;
    }

    public function prepareValue($value)
    {
        return Utils::truncate(strip_tags($value), 100);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    protected function getHtmlInput($attrs = [])
    {
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name;
        $attrs['value'] = $this->value;
        /*if($this->variant){
            $attrs['name'] = 'variant['.$this->name.'][]';
        }*/

        if (!empty($this->disabled)) {
            $attrs['disabled'] = 'disabled';
        }
        if (!empty($this->default)) {
            $attrs['placeholder'] = $this->default;
        }
        $attrs['class'] = $this->class;
        $example = empty($this->example) ? '' : sprintf('<br/><span class="example">%s</span>', $this->example);
        return sprintf('<input %s />%s', $this->_make_attributes_html($attrs), $example);
    }

    protected function _make_attributes_html($attrs)
    {
        unset($attrs['error']);
        $tmp = [];
        foreach ($attrs as $k => $v) {
            $tmp[] = sprintf('%s="%s"', $k, htmlspecialchars($v ?? ''));
        }
        return implode(" ", $tmp);
    }

    public function setQueryValue()
    {
        $queryPostValue = Query::$post[$this->name];
        if (isset($this->complex_field_title, $this->complex_field_row_id, $this->complex_field_prop_id)) {
            $queryPostValue = Query::$post[$this->complex_field_title][$this->complex_field_row_id][$this->complex_field_prop_id];
        }

        if (isset($queryPostValue)) {
            $this->value = $queryPostValue;
        }
    }

    public function removeAttach()
    {
        $this->attach = null;
    }

    public function validate()
    {
        $this->messages = [];
        $this->setQueryValue();

        if (!empty($this->required) && empty($this->value)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.IS_EMPTY}',
                'error'
            );
        }
        if (!empty($this->value) && !empty($this->format) && !preg_match($this->format . 'uis', $this->value)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.FILLED_WRONG}', 'error'
            );
        }

        return $this->messages;
    }
}