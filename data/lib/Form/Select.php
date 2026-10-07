<?php

namespace App\Form;

use App\Admin\Template;
use App\Structure;

class Select extends Field
{

    protected $options = array();

    public function __construct($field)
    {
        parent::__construct($field);
        if (!empty($field->options_data) && !is_array($field->options_data)) {
            $field->options_data = unserialize($field->options_data);
            foreach ($field->options_data as $key => $option) {
                if (!isset($option['title'])) {
                    $field->options_data[$key]['title'] = $option['value'];
                }
            }
        }
        if (!empty($field->options_data)) {
            $this->options = $field->options_data;
        }
        if (!empty($field->prepare) && method_exists($this, $field->prepare)) {
            $this->prepare = $field->prepare;
        }
    }

    public function getHtml()
    {
        if (empty($this->options)) {
            return '';
        }
        $attrs = array();
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['name'] = $this->name;
        $attrs['class'] = $this->class;
        if (!empty($this->prepare)) {
            $method = $this->prepare;
            $options = $this->$method();
            return sprintf('<select %s>%s</select>', $this->_make_attributes_html($attrs), $options);
        } else {
            $options = array();
            if (empty($this->required)) {
                $options[] = $this->getOptionHtml('', "---");
            }
            foreach ($this->options as $option) {
                $options[] = $this->getOptionHtml($option['value'], $option['title']);
            }
            return sprintf('<select %s>%s</select>', $this->_make_attributes_html($attrs), implode("\n", $options));
        }
    }

    private function getOptionHtml($value = '', $title = '')
    {
        $attrs = array('value' => $value);

        if ($value == $this->value) {
            $attrs['selected'] = 'selected';
        }
        return sprintf(
            '<option %s>%s</option>',
            $this->_make_attributes_html($attrs),
            $title
        );
    }

    public function prepareValue($value)
    {
        if (!empty($this->options)) {
            foreach ($this->options as $option) {
                if ($option['value'] == $value) {
                    return $option['title'];
                }
            }
        }
        return $value;
    }

    protected function _parent_select_field()
    {
        $tpl = new Template(true);
        $tree = Structure::get_instance()->get_tree();
        $tpl->assign('tree', $tree);
        $tpl->assign('spacer', ' - ');
        $tpl->assign('cur_pid', $this->value);
        $options = sprintf(
            '<option value="0" %s>Корень сайта</option>',
            ($this->value === 0) ? 'selected="selected"' : ''
        );
        $options2 = sprintf('<option value="">--------------------</option>');
        $options2 .= sprintf(
            '<option value="current" %s>Текущий уровень</option>',
            ($this->value === 'current') ? 'selected="selected"' : ''
        );
        $options2 .= sprintf(
            '<option value="-0" %s>Подразделы текущего раздела</option>',
            ($this->value === '-0') ? 'selected="selected"' : ''
        );
        $options2 .= sprintf(
            '<option value="-1" %s>Подразделы от 1 уровня</option>',
            ($this->value === '-1') ? 'selected="selected"' : ''
        );
        $options2 .= sprintf(
            '<option value="-2" %s>Подразделы от 2 уровня</option>',
            ($this->value === '-2') ? 'selected="selected"' : ''
        );
        $options2 .= sprintf(
            '<option value="-3" %s>Подразделы от 3 уровня</option>',
            ($this->value === '-3') ? 'selected="selected"' : ''
        );
        $options2 .= sprintf(
            '<option value="-4" %s>Подразделы от 4 уровня</option>',
            ($this->value === '-4') ? 'selected="selected"' : ''
        );
        $options2 .= sprintf(
            '<option value="-5" %s>Подразделы от 5 уровня</option>',
            ($this->value === '-5') ? 'selected="selected"' : ''
        );
        return $options . $tpl->fetch('menu/parent-select.tpl') . $options2;
    }

    protected function _parent_simple_field()
    {
        $tpl = new Template(true);
        $tree = Structure::get_instance()->get_tree();
        $tpl->assign('tree', $tree);
        $tpl->assign('spacer', ' - ');
        $tpl->assign('cur_pid', $this->value);
        return $tpl->fetch('menu/parent-select.tpl');
    }
}

?>
