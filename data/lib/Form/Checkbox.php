<?php

namespace App\Form;

use App\Query;

class Checkbox extends Text
{

    protected $class = "checkbox";

    public function getHtml($id = null)
    {
        $expl_name = explode('_', $this->name);

        if (count($expl_name) > 0) {
            if ($expl_name[0] == 'field' && $expl_name[2] == 'area') {
                return $this->getHtmlOnSite();
            }
        }
        $attrs = array();
        if (!empty($this->value) || $this->name == 'field_75_area_15') {
            $attrs['checked'] = 'checked';
        }
        $attrs['id'] = empty($this->id) ? !empty($id) ? $this->name . '_' . $id : $this->name . '_0' : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name;
        $attrs['value'] = 1;
        $attrs['class'] = 'selected_field ' . $this->class;
        return sprintf('<input %s />', $this->_make_attributes_html($attrs));
    }

    public function getHtmlOnSite()
    {
        $attrs = array();
        if (!empty($this->value)) {
            $attrs['checked'] = 'checked';
        }
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name;
        $attrs['value'] = 1;
        $attrs['class'] = $this->class;
        return sprintf(
            '<div class="type_checkbox"><input %s /><label for="%s">%s</label></div>',
            $this->_make_attributes_html($attrs),
            $attrs['id'],
            $this->title
        );
    }

    public function prepareValue($value)
    {
        return sprintf(
            '<span class="t-icon %s %s" title="%s"></span>',
            empty($value) ? 'not-active' : '',
            $this->name,
            $this->title
        );
    }

    public function getInsertValue()
    {
        return empty($this->value) ? 0 : 1;
    }

    public function setQueryValue()
    {
        $queryPostValue = Query::$post[$this->name];
        if (isset($this->complex_field_title, $this->complex_field_row_id, $this->complex_field_prop_id)) {
            $queryPostValue = Query::$post[$this->complex_field_title][$this->complex_field_row_id][$this->complex_field_prop_id];
        }
        $this->value = empty($queryPostValue) ? 0 : 1;;
    }

    public function getCheckboxgroupHtml()
    {
        $attrs = array();
        if (!empty($this->checked)) {
            $attrs['checked'] = 'checked';
        }
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name;
        $attrs['value'] = $this->value;
        $attrs['class'] = $this->class;
        return sprintf(
            '<div class="type_checkbox"><input %s /><label for="%s">%s</label></div>',
            $this->_make_attributes_html($attrs),
            $attrs['id'],
            $this->value
        );
    }
}

?>