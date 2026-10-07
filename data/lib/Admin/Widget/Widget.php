<?php

namespace App\Admin\Widget;

use App\Admin\Template;
use App\Registry;
use App\Item\Widget as ItemWidget;

class Widget
{
    protected ItemWidget $widget;
    protected Template $tpl;
    protected $db;

    public function __construct(ItemWidget $widget)
    {
        $this->widget = $widget;
        $this->db = Registry::get('db');
    }

    public function getHtml()
    {
        $this->tpl = new Template();
        $this->tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $this->setTemplateData();
        return $this->tpl->fetch(sprintf('widget/%s.tpl', $this->widget->name));
    }

    protected function setTemplateData()
    {

    }
}