<?php

namespace App\Form;

class Radiogroup extends Radio
{

    private $radios = array();
    private $options = array();


    public function __construct($field)
    {
        parent::__construct($field);
        if (!empty($field->options_data)) {
            $this->options = unserialize($field->options_data);
            $i = 1;
            foreach ($this->options as $option) {
                $attrs = array();
                $fieldTmp = $field;
                $fieldTmp->options_data = $option;
                $radio = new Radio($field);
                $radio->id = (!empty($this->id) ? $this->id : $this->name) . $i++;
                $radio->name = $this->name;
                $radio->value = $option['value'];
                $radio->title = $option['value'];
                $radio->type = 'radio';
                $this->radios[] = $radio;
            }
        }
    }


    public function getHtml()
    {
        if (empty($this->radios)) {
            return '';
        }
        $radios = array();
        foreach ($this->radios as $radio) {
            $radio->selected = $radio->value == $this->value;
            $radios[] = $radio->getHtml();
        }
        return implode("<br />", $radios);
    }


    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getInsertValue()
    {
        return $this->value;
    }
}

?>
