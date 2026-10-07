<?php

namespace App\Admin\Log;

use App\Admin\Template;
use App\Item\Log as ItemLog;

abstract class Log
{
    protected ItemLog $widget;
    protected Template $tpl;

    public function __construct(ItemLog $log)
    {
        $this->log = $log;
    }

    abstract function setTemplateData(): void;
    abstract static function isActive(): bool;

    public function getHtml()
    {
        $this->tpl = new Template();
        $this->tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $this->setTemplateData();
        return $this->tpl->fetch(sprintf('log/%s.tpl', strtolower($this->log->class)));
    }
}