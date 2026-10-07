<?php

namespace App\Form;

use App\Attach;
use App\Query;

class Multiimage extends Multifile
{

    protected $attaches = array();

    protected $attach_type = 'Image';

    protected $class = 'label__file';

    public function getInsertValue()
    {
        $values = array();
        foreach ($this->attaches as $attach) {
            $values[] = $attach->id;
        }
        return join(';', $values);
    }

    public function setValue($value)
    {
        if (!empty($value)) {
            $this->value = $value;
            $ids = explode(';', $this->value);
            foreach ($ids as $id) {
                if (empty($id)) {
                    continue;
                }
                
                $this->attaches[$id] = Attach::factory($this->attach_type, $id, $this->params);

                if(!empty($this->attaches[$id])) {
                    $this->attaches[$id]->cropData = $this->attaches[$id];
                }
            }
        }
    }

    public function getSpecValue()
    {
        return $this->attaches;
    }

    public function setQueryValue()
    {
        if (!empty(Query::$post['clear_' . $this->name])) {
            foreach (Query::$post['clear_' . $this->name] as $id => $value) {
                if (!empty($this->attaches[$id])) {
//                    $this->attaches[$id]->delete();
                    unset($this->attaches[$id]);
                }
            }
        }

        if (!empty(Query::$post[$this->name . '_broswer'])) {
            foreach (Query::$post[$this->name . '_broswer'] as $file) {
                $attach = Attach::factory($this->attach_type, 0, $this->params);
                $attach->uploadFromServer($file, $this->params['node_type']);
                $this->value = empty($this->attach->id) ? 0 : $this->attach->id;
                if (!empty($attach->id)) {
                    $this->attaches[$attach->id] = $attach;
                }
            }
            return;
        }


        if (!empty(Query::$files[$this->name])) {
            foreach (Query::$files[$this->name] as $file) {
                if (!$file['error']) {
                    $attach = Attach::factory($this->attach_type, 0, $this->params);
                    $attach->upload($file, $this->params['node_type']);
                    if (!empty($attach->id)) {
                        $this->attaches[$attach->id] = $attach;
                    }
                }
            }
        }

        if (!empty(Query::$post['sorting_' . $this->name])) {
//			pre($this->attaches);
            $add = array();
            $sort = explode(';', Query::$post['sorting_' . $this->name]);
            $attaches = array();
            foreach ($sort as $id) {
                if (array_key_exists($id, $this->attaches)) {
                    $attaches[$id] = $this->attaches[$id];
                }
            }

            //all images with new uploaded
            $sort = array_keys($this->attaches);
            foreach ($sort as $id) {
                if (!array_key_exists($id, $attaches)) {
                    $add[$id] = $this->attaches[$id];
                }
            }

            $this->attaches = array_merge($attaches, $add);
        }
    }

    public function getHtml($id = null, $name = "")
    {
        return $this->getHtmlInput();
    }

    protected function getHtmlInput($attrs = array())
    {
        $attrs['id'] = empty($this->id) ? $this->name : $this->id;
        $attrs['type'] = $this->type;
        $attrs['name'] = $this->name . '[]';
        $attrs['value'] = $this->value;
        $attrs['class'] = $this->class;
        $attrs['multiple'] = 'multiple';
        return sprintf('<input %s />', $this->_make_attributes_html($attrs));
    }
}

?>
