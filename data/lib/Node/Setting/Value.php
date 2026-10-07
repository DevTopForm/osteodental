<?php

namespace App\Node\Setting;

use App\Model;

class Value extends Model
{

    protected $table = 'nodes_params_values';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        $data = array(
            'type' => $this->type,
            'node' => empty($this->node) ? 0 : $this->node,
            'area' => empty($this->area) ? 0 : $this->area,
            'name' => $this->name,
            'value' => empty($this->value) ? '' : $this->value,
        );
        return $data;
    }

    public function validate()
    {
        $valid = true;
        return $valid;
    }
}

?>
