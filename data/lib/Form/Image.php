<?php

namespace App\Form;

use App\Attach;
use App\Image as AppImage;

class Image extends File
{

    protected $attach_type = 'Image';

    protected $class = 'label__file';


    public function prepareValue($value)
    {
        if (!empty($value)) {
            return Attach::factory($this->attach_type, $value);
        }
        return null;
    }

    public function getHtml($id = null, $name = "")
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
        return sprintf('<input %s />', $this->_make_attributes_html($attrs));
    }

    public function getSpecValue()
    {
        return $this->attach;
    }
}
