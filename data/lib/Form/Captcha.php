<?php

namespace App\Form;

use App\Message;

class Captcha extends Text
{

    protected $class = "text captcha";
    protected $type = "text";

    public function getHtml()
    {
        $this->value = '';
        return sprintf(
            '<img class="captcha" alt="captcha" src="/htdocs/captcha/?%s&key=%s" onclick="this.src=\'/htdocs/captcha/?\'+Math.random()+\'&key=%s\'"/>%s',
            time(),
            $this->name,
            $this->name,
            $this->getHtmlInput()
        );
    }

    public function validate()
    {
        $this->setQueryValue();
        if (!empty($this->required) && empty($this->value)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.IS_EMPTY}',
                'error'
            );
        }
        if (!empty($this->value) && (empty($_SESSION['captcha_' . $this->name]) || $this->value != $_SESSION['captcha_' . $this->name])) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.FILLED_WRONG}', 'error'
            );
        }
        unset($_SESSION['captcha_' . $this->name]);
        return $this->messages;
    }
}

?>
