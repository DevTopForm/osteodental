<?php

namespace App\Form;

use App\Query;

class Checkboxgroup extends Checkbox
{

    private $checkboxes = array();
    private $options = array();

    public function __construct($field)
    {
        parent::__construct($field);
        $options = unserialize($field->options_data);
        if (!empty($options)) {
            $this->options = $options;
            $i = 1;
            foreach ($this->options as $option) {
                $attrs = array();
                $checkbox = new Checkbox($field);
                $checkbox->id = (!empty($this->id) ? $this->id : $this->name) . $i++;
                $checkbox->name = $this->name . '[]';
                $checkbox->value = $option['value'];
                $checkbox->title = (isset($option['title']) ? $option['title'] : $option['value']);
                $checkbox->type = 'checkbox';
                $this->checkboxes[] = $checkbox;
            }
        }
    }

    public function getSpecValue()
    {
        if (!empty($this->value)) {
            $val = unserialize($this->value);
            return implode(", ", $val);
        } else {
            return '';
        }
    }

    public function getHtml()
    {
        if (empty($this->checkboxes)) {
            return '';
        }
        $checkboxes = array();
        $this->value = unserialize($this->value);
        foreach ($this->checkboxes as $checkbox) {
            if (!empty($this->value)) {
                $checkbox->checked = in_array($checkbox->value, $this->value);
            }
            $checkboxes[] = $checkbox->getCheckboxgroupHtml();
        }
        return sprintf(
            '<div class="type_checkbox_wrap"><div class="type_checkbox_label"><label>%s</label></div>%s</div>',
            $this->title,
            implode("", $checkboxes)
        );
    }

    public function setValue($value)
    {
        $this->value = unserialize($value);
    }

    public function getInsertValue()
    {
        return serialize($this->value);
    }

    public function setQueryValue()
    {
        $this->value = empty(Query::$post[$this->name]) ? 0 : serialize(Query::$post[$this->name]);
    }

}

?>