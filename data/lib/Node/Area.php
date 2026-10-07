<?php
namespace App\Node;

use App\Model;
use App\Node;
use App\Node\Type\Template as TypeTemplate;
use App\Registry;

class Area extends Model
{

    protected $table = 'nodes_areas';
    protected $isCachable = true;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        return array(
            'node' => $this->node,
            'area' => $this->area,
            'template' => $this->template,
            'node_id' => empty($this->node_id) ? 0 : $this->node_id
        );
    }

    public function validate()
    {
        $valid = true;
        return $valid;
    }

    protected function prepareData()
    {
        if (!empty($this->node_id)) {
            $this->object = new Node($this->node_id);
        }
    }

    public function getTemplate()
    {
        if (!empty($this->node_id)) {
            $template = new TypeTemplate($this->template);
        }
        return empty($template->file) ? '' : $template->file;
    }

    public static function getByNodeArea($node, $area)
    {
        $db = Registry::get('db');
        $item = static::getByKeys(array('node' => $node, 'area' => $area));
        if (empty($item->id)) {
            $item = new static();
            $item->node = $node;
            $item->area = $area;
        }
        return $item;
    }
}

?>
