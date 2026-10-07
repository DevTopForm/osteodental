<?php

namespace App\Form;

use App\Query;

class Date extends Text
{

    protected $class = "date text";
    protected $type = "date";

    public function prepareValue($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function setQueryValue()
    {
        if (!empty(Query::$post['clear_' . $this->name])) {
            $this->value = 0;
        } elseif (isset(Query::$post[$this->name])) {
            $this->value = Query::$post[$this->name];
        }
    }

    protected function getHtmlInput($attrs = array())
    {
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name;
        $attrs['value'] = empty($this->value) ? date('Y-m-d', time()) : $this->prepareValue($this->value);
        $attrs['class'] = $this->class;
        $example = empty($this->example) ? '' : sprintf('<span class="example">%s</span>', $this->example);
        return sprintf('<input %s />%s', $this->_make_attributes_html($attrs), $example);
    }

    public function getInsertValue()
    {
        return empty($this->value) ? date('Y-m-d', time()) : $this->prepareValue($this->value);
    }
}
