<?php

namespace App\Control;

abstract class Element
{

    protected $bindedParams = array();

    public function getParams()
    {
        return array();
    }

    public function bindWith()
    {
        $controlElements = func_get_args();

        if (1 == count($controlElements) && is_array(reset($controlElements))) {
            $controlElements = reset($controlElements);
        }

        foreach ($controlElements as $control) {
            $this->bindWithControlElement($control);
        }
    }

    protected function bindWithControlElement($control)
    {
        $class = static::class;

        if (!$control instanceof $class) {
            //mb exception here?
            return;
        }
        $this->addBindedParams($control->getParams());
    }

    protected function addBindedParams($params)
    {
        if (is_array($params)) {
            $this->bindedParams = array_merge($this->bindedParams, $params);
        }
    }

    public function getBindedParamsQueryString()
    {
        if (empty($this->bindedParams)) {
            return '';
        }
        return '&amp;' . http_build_query($this->bindedParams, '', '&amp;');
    }
}