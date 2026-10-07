<?php

namespace App\Form;

class Textarea extends Text
{

    protected $class = "text";

    public function __construct($field)
    {
        parent::__construct($field);
        $this->editor = $field->editor;
    }

    public function getHtml()
    {
        $attrs = [];
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['name'] = $this->name;
        $attrs['class'] = $this->class . (empty($this->editor) ? '' : ' editor');
        if (!empty($this->default)) {
            $attrs['placeholder'] = $this->default;
        }

        $attrs['rows'] = 5;
        $example = empty($this->example) ? '' : sprintf('<br/><span class="example">%s</span>', $this->example);
        return sprintf('<textarea %s>%s</textarea>%s', $this->_make_attributes_html($attrs), $this->value, $example);
    }
}

?>
