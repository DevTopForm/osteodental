<?php

namespace App\Form;

use App\Message;

class Phone extends Field
{

    protected $class = "text";
    protected $type = "tel";

    public function validate()
    {
        $this->messages = array();
        $this->setQueryValue();
        if (!empty($this->required) && empty($this->value)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.IS_EMPTY}',
                'error'
            );
        }
        if (!empty($this->value) && !preg_match(
                '/^(\+)?[0-9]{1,3}(([[:space:]-])?(\()?[0-9]+(\))?)+$/uis',
                $this->value
            )) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.FILLED_WRONG}', 'error'
            );
        }
        return $this->messages;
    }
}

?>
