<?php

namespace App\Form;

use App\Message;
use App\Query;

class Yapoint extends Text
{

    public $coords = array(
        'x' => 0,
        'y' => 0,
    );

    public function getHtml()
    {
        return sprintf(
            'x: <input type="text" name="%s[x]" value="%s" class="small_text" id="coord_%s_x"/>&nbsp;&nbsp;y: <input type="text" name="%s[y]" value="%s" class="small_text" id="coord_%s_y"/>',
            $this->name,
            $this->coords['x'],
            $this->name,
            $this->name,
            $this->coords['y'],
            $this->name
        );
    }

    public function getSpecialHtml()
    {
        return '';
    }

    public function prepareValue($value)
    {
        $coords = explode('x', $value);
        if (count($coords) == 2) {
            $this->coords['x'] = $coords[0];
            $this->coords['y'] = $coords[1];
        }
        return $value;
    }

    public function setValue($value)
    {
        $coords = explode('x', $value);
        if (count($coords) == 2) {
            $this->coords['x'] = $coords[0];
            $this->coords['y'] = $coords[1];
        }
    }

    public function setQueryValue()
    {
        if (isset(Query::$post[$this->name])) {
            $this->coords['x'] = Query::$post[$this->name]['x'];
            $this->coords['y'] = Query::$post[$this->name]['y'];
        }
    }

    public function getInsertValue()
    {
        return join('x', $this->coords);
    }

    public function validate()
    {
        $this->setQueryValue();
        if (!empty($this->required) && empty($this->coords['x']) && empty($this->coords['y'])) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.IS_EMPTY}',
                'error'
            );
        }
    }
}

?>
