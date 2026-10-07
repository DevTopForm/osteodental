<?php

namespace App\Admin\Controller\Ajax;

use App\Admin\Template;
use App\Node as AppNode;
use App\Area as AppArea;
use App\Node\Area as NodeArea;
use App\Node\Type as NodeType;
use App\Node\Type\Template as NodeTypeTemplate;
use App\Node\Setting;
use App\Node\Setting\Item;
use App\Site\Setting\Item as SiteSettingItem;

class Area extends Action
{

    protected $tpl = 'ajax/area.tpl';

    public function run()
    {
        switch ($this->path[0]) {
            case 'edit':
                $this->editNodeArea();
                break;
            case 'params':
                $this->editAreaParams();
                break;
            case 'add':
                break;
        }
    }

    protected function editNodeArea()
    {
        $node = new AppNode(@$this->path[1]);
        if (empty($node->id)) {
            throw new \Exception('Node is not defined');
        }
        $area = new AppArea(@$this->path[2]);
        if (empty($area->id)) {
            throw new \Exception('Area is not defined');
        }
        $templates = NodeTypeTemplate::getListByKey('in_block', 1)->getItems();
        $types_templates = array();
        foreach ($templates as $item) {
            if (empty($types_templates[$item->type])) {
                $types_templates[$item->type] = array();
            }
            $types_templates[$item->type][] = $item;
        }
        $data = array(
            'type' => NodeType::getListByKey('in_block', 1)->getItems(),
            'template' => $types_templates,
            'nodes' => AppNode::getList()->getItems(),
        );
        $tpl = new Template();
        $tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $tpl->assign('state', $this->path[0]);
        $tpl->assign('node', $node);
        $tpl->assign('data', $data);
        $tpl->assign('area', $area);
        $tpl->assign('nodeArea', NodeArea::getByNodeArea($node->id, $area->id));
        $tpl->display($this->tpl);
        die;
    }

    protected function editAreaParams()
    {
        $node = new AppNode(@$this->path[1]);
        if (empty($node->id)) {
            throw new \Exception('Node is not defined');
        }
        $area = new AppArea(@$this->path[2]);
        if (empty($area->id)) {
            throw new \Exception('Area is not defined');
        }
        $nodeArea = NodeArea::getByNodeArea($node->id, $area->id);
        if (empty($nodeArea->id)) {
            return $this->editNodeArea();
        }
        $fields = Setting::getFieldsList(array('type' => $nodeArea->object->getType(), 'local' => 1));
        $values = Item::get('assoclist', array('node' => $nodeArea->object->id, 'area' => 0));
        $values_local = Item::get('assoclist', array('node' => $nodeArea->object->id, 'area' => $area->id));
        $values = array_merge($values, $values_local);
        $global = SiteSettingItem::get('assoclist');
        foreach ($fields as $key => $field) {
            if (isset($values[$field->name])) {
                $fields[$key]->setValue($values[$field->name]->value);
            } elseif (isset($global[$field->name])) {
                $fields[$key]->setValue($global[$field->name]->value);
            }
        }
        $tpl = new Template();
        $tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $tpl->assign('state', $this->path[0]);
        $tpl->assign('node', $nodeArea->object);
        $tpl->assign('fields', $fields);
        $tpl->assign('area', $area);
        $tpl->assign('nodeArea', $nodeArea);
        $tpl->display($this->tpl);
        die;
    }

}