<?php

namespace App\Form;

use App\Attach;
use App\Message;
use App\Query;

class File extends Text
{

    protected $class = "label__file";
    protected $type = 'file';
    protected $attach_type = 'File';
    protected $attach = null;

    public function getInsertValue()
    {
        return empty($this->value) ? 0 : $this->value;
    }

    public function setValue($value)
    {
        if (!empty($value)) {
            $this->value = $value;
            $this->attach = Attach::factory($this->attach_type, $this->value);
        }
    }

    public function prepareValue($value)
    {
        if (!empty($value) && !empty($this->attach)) {
            return $this->attach->src_name;
        }
        return '';
    }

    public function setQueryValue()
    {
        if (isset($this->complex_field_title, $this->complex_field_row_id, $this->complex_field_prop_id)) {
            $clearFlag = Query::$post['clear_' . $this->complex_field_title][$this->complex_field_row_id][$this->complex_field_prop_id];
        } else {
            $clearFlag = Query::$post['clear_' . $this->name];
        }

        if (!empty($clearFlag)) {
            $this->attach = Attach::factory($this->attach_type, $this->value);
            if (!is_null($this->attach)) {
                $this->attach->delete();
                $this->attach = null;
                $this->value = 0;
            }
        }

        if (!empty(Query::$post[$this->name . '_broswer'])) {
            if (!is_null($this->attach)) {
                $this->attach->delete();
            }
            $this->attach = Attach::factory($this->attach_type, 0);
            $this->attach->setParams($this->params);
            $this->attach->uploadFromServer(Query::$post[$this->name . '_broswer']);
            $this->value = empty($this->attach->id) ? 0 : $this->attach->id;
            return;
        }

        if (isset($this->complex_field_title, $this->complex_field_row_id, $this->complex_field_prop_id)) {
            $queryPostValue = Query::$files[$this->complex_field_title][$this->complex_field_row_id][$this->complex_field_prop_id];
        } else {
            $queryPostValue = Query::$files[$this->name];
        }

        if (!empty($queryPostValue['tmp_name'])) {
            if (!is_null($this->attach)) {
                $this->attach->delete();
            }
            $this->attach = Attach::factory($this->attach_type, 0);
            $this->attach->setParams($this->params);
            $this->attach->upload($queryPostValue);
            $this->value = empty($this->attach->id) ? 0 : $this->attach->id;
        } elseif (is_array($queryPostValue) && !isset($queryPostValue['tmp_name'])) {
            $ids = [];
            foreach (Query::$files[$this->name] as $id => $file) {
                $attach = Attach::factory($this->attach_type, 0);
                $attach->setParams($this->params);
                $attach->upload($queryPostValue[$id]);
                $this->attach[] = $attach;
                $ids[] = $attach->id;
            }
            $this->value = empty($ids) ? 0 : implode(",", $ids);
        }
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
        $example = empty($this->example) ? '' : sprintf('<br/><span class="example">%s</span>', $this->example);
        return sprintf('<input %s />%s', $this->_make_attributes_html($attrs), $example);
    }

    public function validate()
    {
        $this->messages = [];
        $this->setQueryValue();
        if (!empty($this->attach->messages)) {
            $this->messages = $this->attach->messages;
        }
        if (!empty($this->required) && empty($this->value)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.IS_EMPTY}',
                'error'
            );
        }
        return $this->messages;
    }

    public function getAttach()
    {
        return $this->attach;
    }

    public function getSpecValue()
    {
        if (!empty($this->value)) {
            $file = new \App\File($this->value);
            $this->value = "<a target='_blank' href='https://" . $_SERVER['SERVER_NAME'] . $file->getLink() . "'>Скачать</a>";
        }
        return $this->value;
    }
}
