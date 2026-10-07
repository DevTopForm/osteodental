<?php

namespace App\Form;

use App\Query;
use App\Structure;

class Multisel2area extends Multiselect
{

    protected $options = array();
    protected $class = 'select';

    public function getHtml()
    {
        $attrs = array();
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['name'] = $this->name . '[]';
        $attrs['class'] = $this->class;
        $attrs['multiple'] = "multiple";
        if (!empty($this->disabled)) {
            $attrs['disabled'] = 'disabled';
        }
        $options = array();
        if (!empty($this->prepare)) {
            $method = $this->prepare;
            $options = $this->$method();

            return sprintf('<input type="hidden" name="%s[]" value="" /><div id="multiselect_%s" class="js-multiselect"><select %s>%s</select></div>', $this->name, $this->name, $this->_make_attributes_html($attrs), implode("\n", $options));
        } else {
            foreach ($this->options as $option) {
                $options[] = $this->getOptionHtml($option['value'], $option['title']);
            }
        }

        return sprintf('<input type="hidden" name="%s[]" value="" /><div id="multiselect_%s" class="js-multiselect"><select %s>%s</select></div>', $this->name, $this->name, $this->_make_attributes_html($attrs), implode("\n", $options));
    }

    private function getOptionHtml($value = '', $title = '')
    {
        $attrs = array('value' => $value);
        if (!empty($this->value) && in_array($value, $this->value)) {
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
        $bk_value = $value;
        $value = explode(',', $value);
        if (empty($value)) {
            $value = array();
        } elseif (!is_array($value)) {
            $value = array($value);
        }
        $return = array();
        if (!empty($this->options)) {
            foreach ($this->options as $option) {
                if (in_array($option['value'], $value)) {
                    $return[] = $option['title'];
                }
            }
        }
        return empty($return) ? '' : join(', ', $return);
    }

    public function setValue($value)
    {
        $this->value = explode(',', $value);
        if (empty($this->value)) {
            $this->value = array();
        } elseif (!is_array($this->value)) {
            $this->value = array($this->value);
        }
    }

    public function setQueryValue()
    {
        if (isset(Query::$post[$this->name])) {
            $this->value = array_filter(Query::$post[$this->name]);
        } elseif (isset(Query::$post['save'])) {
            $this->value = array();
        }
    }

    public function getInsertValue()
    {
        foreach ($this->value as $key => $value) {
            $this->value[$key] = addslashes($value);
        }
        return implode(',', $this->value);
    }

    /**
     * Метод обработки цен для металобазы
     */
    public function prices()
    {
        $options = array();
        unset($this->options);

        $tree = Structure::get_instance()->get_tree(3643);
        $this->getStructurePrice($tree, 1);

        foreach ($this->options as $option) {
            $options[] = $this->getOptionHtml($option['value'], $option['title']);
        }

        return $options;
    }

    protected function getStructurePrice($tree, $iteration)
    {
        $br = '';

        if ($iteration > 1) {
            for ($i = 0; $i <= $iteration; $i++) {
                $br .= '&nbsp;&nbsp;';
            }
        }

        foreach ($tree as $key => $parent) {
            if ($parent['type'] == 'pricelist') {
                $this->options[] = array(
                    'title' => $br . $parent['title'],
                    'value' => $parent['id'],
                    'disabled' => 1
                );
            } else {
                if ($parent['type'] == 'prices') {
                    $this->options[] = array(
                        'title' => $br . $parent['title'],
                        'value' => $parent['id']
                    );
                }
            }

            if (isset($parent['childs'])) {
                $this->getStructurePrice($parent['childs'], $iteration + 1);
            }
        }
    }
}

?>