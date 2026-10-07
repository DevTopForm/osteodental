<?php

namespace App\Form;

class Hidden extends Text
{

    protected $class = "";
    protected $sorter = 1;

    public function __construct($field)
    {
        $this->class = empty($field->ident) ? '' : $field->ident;
        parent::__construct($field);
        $this->example = '';
    }

    public function getInsertValue()
    {
        return (empty($this->value)) ? 0 : $this->value;
    }

    public function getHtml($id = null, $name = ""): string
    {
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $name ?: $this->name;
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
}
