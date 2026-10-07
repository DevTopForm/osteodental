<?php

namespace App\Form;

use App\Query;
use App\Structure;
use App\Template;

class Multiselect extends Select
{

    protected $options = array();
    protected $class = 'multiselect';

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
    }

    public function getHtml()
    {
//        pre($this->options);



        $html = '
            <div 
                    class="fast-search js-multiselect-search"
                    data-table="%s"
                    data-field="%s"
                    data-value="%s"
            >
            <meta 
                    type="hidden" 
                    class="fast-search__hidden" 
                    name="%s" 
                    value="%s"
                >

                <input 
                    type="text" 
                    class="label__input fast-search__input" 
                    name="%s_search" 
                    value="" 
                    placeholder="Введите название"
                >
    
                <div class="fast-search__block">
                   %s
                </div>
            </div>
        ';

        $options_html = '';

        if(!empty($this->value)){
            $values = explode(',', $this->value);

            if(!empty($this->options)){
                foreach ($this->options as $option)
                {
                    if (in_array($option['value'], $values)) {
                        $options_html .= sprintf(
                            '
                            <div class="fast-item">
                                <span>%s</span>
                                <button class="btn fast-item__btn" data-id="%s" aria-label="Удалить Антик паста">
                                    <svg fill="none" width="10" height="10">
                                        <use xlink:href="/adm/assets/img/sprite.svg#cross"></use>
                                    </svg>
                                </button>
                            </div>
                            ', $option['title'], $option['value']
                        );
                    }
                }
            }
        }

//        pre($this->getField);
        return sprintf(
            $html,
            $this->table_data,
            $this->table_filter,
            $this->table_value,
            $this->name,
            $this->value,
            $this->name,

            $options_html
        );
    }

    private function checkValue($value)
    {
        if ($value && $this->options) {
            $value = explode(",", $value);
            foreach ($value as $val) {
                foreach ($this->options as $option) {
                    if ($option['value'] == $val) {
                        $result[] = $val;
                    }
                }
            }
            return ($result) ? implode(",", $result) : "";
        }
    }

    public function prepareValue($value)
    {
        if ($value && !empty($this->options)) {
            $value = explode(',', $value);
            $value_arr = array();
            foreach ($this->options as $option) {
                if (in_array($option['value'], $value)) {
                    $value_arr[] = $option['title'];
                }
            }
            return implode(', ', $value_arr);
        }
        return $value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setQueryValue()
    {
        if (isset(Query::$post[$this->name])) {
            $this->value = Query::$post[$this->name];
        }
    }

    public function getInsertValue()
    {
        //убрать последнюю запятую
        return substr($this->value, 0, strlen($this->value) - 1);
    }

    protected function _parent_simple_field()
    {
        $tpl = new Template(true);
        $tree = Structure::get_instance()->get_tree();
        $tpl->assign('tree', $tree);
        $tpl->assign('spacer', ' - ');
        $tpl->assign('cur_pid', $this->value);
        return $tpl->fetch('menu/parent-multi-select.tpl');
    }
}

?>
