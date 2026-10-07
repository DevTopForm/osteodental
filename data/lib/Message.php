<?php

namespace App;

use App\Admin\Template as AdminTemplate;

class Message
{
    public $type;

    public $html;

    private $body;

    public function __construct($body, $type = 'info')
    {
        $this->type = $type;
        $this->body = $body;
        $tpl = new AdminTemplate();
        $tpl->assign('type', $this->type);
        $tpl->assign('body', $this->body);
        $this->html = $tpl->fetch('../adm/message.tpl');
        unset($tpl);
    }
}

?>
