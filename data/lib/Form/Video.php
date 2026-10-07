<?php

namespace App\Form;

use App\Attach;
use App\Node;
use App\Query;

class Video extends Field
{

    protected $class = "";


    public function getInsertValue()
    {
        return serialize($this->value);
    }

    public function setValue($value)
    {
        if ($value) {
            $this->value = unserialize($value);
            $this->attach = Attach::factory('Image', $this->value['img'], $this->params);
        }
    }

    public function setQueryValue()
    {
        if (isset(Query::$post[$this->name])) {
            $this->value = Query::$post[$this->name];
        }
        if (!empty(Query::$files[$this->name]['image']['tmp_name'])) {
            if (!is_null($this->attach)) {
                $this->attach->delete();
            }
            $urlArr = (explode('/', $_SERVER['REQUEST_URI']));
            $node_type = "";
            if (((int)$urlArr[3]) == $urlArr[3]) {
                $nodeObj = new Node($urlArr[3]);
                $node_type = $nodeObj->type->type;
            }
            $this->attach = Attach::factory('Image', 0, $this->params);
            $this->attach->upload(Query::$files[$this->name]['image'], $node_type);
            $this->value['img'] = empty($this->attach->id) ? 0 : $this->attach->id;
        } elseif (!empty(Query::$post[$this->name]['prevyuVideo']) && !empty(Query::$post[$this->name]['img'])) {
            $urlArr = (explode('/', $_SERVER['REQUEST_URI']));
            $node_type = "";
            if (((int)$urlArr[3]) == $urlArr[3]) {
                $nodeObj = new Node($urlArr[3]);
                $node_type = $nodeObj->type->type;
            }
            $this->attach = Attach::factory('Image', 0, $this->params);
            $this->attach->copy(Query::$post[$this->name]['img'], $node_type);
            $this->value['img'] = empty($this->attach->id) ? 0 : $this->attach->id;
        }
    }

    public function getSpecValue()
    {
        return $this->attach;
    }

    public function prepareValue($value)
    {
        $value = @unserialize($value);
        if (!empty($value['img'])) {
            $image = new Image($value['img']);
            if (!$image->id) {
                return '';
            }
            return sprintf(
                '<img src="%s" alt="" class="crop" rel="%s"/>',
                $image->getLink('thumb'),
                $image->id
            );
        }
        return '';
    }

}

?>
