<?php
namespace App\Form;

use App\Message;

class Email extends Field
{

    protected $class = "text";
    protected $type = "email";

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
        if (!empty($this->value) && !preg_match('/^[\w-]+@([\w-]+\.)+[\w-]{2,4}$/uis', $this->value)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.FILLED_WRONG}', 'error'
            );
        }
        return $this->messages;
    }
}

?>
