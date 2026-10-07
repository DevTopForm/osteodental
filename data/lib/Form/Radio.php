<?php

namespace App\Form;

class Radio extends Text
{

    protected $class = "radio";

    public function getHtml()
    {
        $attrs = array();
        if (!empty($this->selected)) {
            $attrs['checked'] = 'checked';
        }
        return $this->getHtmlInput($attrs);
    }

    protected function getHtmlInput($attrs = array())
    {
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name;
        $attrs['value'] = $this->value;
        if (!empty($this->disabled)) {
            $attrs['disabled'] = 'disabled';
        }
        $attrs['class'] = $this->class;
        return sprintf(
            '<input %s />&nbsp;<label for="%s">%s</label>',
            $this->_make_attributes_html($attrs),
            $attrs['id'],
            $this->title
        );
    }

}

?>
