<?php

namespace App\Admin\Page;

use App\Node\Type as NodeType;
use App\Node\Setting\Item as NodeSettingItem;
use App\Node\Setting\Value as NodeSettingValue;
use App\Node\Setting as NodeSetting;
use App\Query;
use App\Registry;
use App\Setting\Item as SettingItem;
use App\Utils;

class Modvalue extends ModLAVED
{

    protected $localTpl = 'content/modvalue.tpl';

    protected function getStateRegexps()
    {
        return array(
            self::STATE_EDIT => '/^edit\/\d+$/i',
        );
    }

    protected function executeRequestProcessing()
    {
        $this->module = new NodeType(@intval($this->parts[3]));
        if (empty($this->module->id)) {
            Utils::redirect($this->admPath);
        }
        parent::executeRequestProcessing();
    }

    protected function setItemFields()
    {
        foreach ($this->fields as $key => $field) {
            $messages = $field->validate();
            if (!empty($messages)) {
                $valid = false;
                $this->errors = array_merge($this->errors, $messages);
            } else {
                if (isset($this->values[$field->name])) {
                    $value = $this->values[$field->name];
                } else {
                    $value = new NodeSettingItem();
                    $value->name = $field->name;
                    $value->node = 0;
                    $value->type = $this->module->type;
                    $value->area = 0;
                }
                $value->value = $field->getValue();
                $value->save();
            }
            $this->fields[$key] = $field;
        }
    }

    protected function editItem()
    {
        $this->fields = NodeSetting::getFieldsList(array('type' => $this->module->type));
        $this->values = NodeSettingItem::get(
            'assoclist',
            array('node' => 0, 'area' => 0, 'type' => $this->module->type)
        );
        $global = SettingItem::get('assoclist');
        $settings = Registry::get('settings');
        $params = $settings->getSiteParams();
        foreach ($this->fields as $key => $field) {
            $this->fields[$key]->setParams($params);
            if (isset($this->values[$field->name])) {
                $this->fields[$key]->setValue($this->values[$field->name]->value);
            } elseif (isset($global[$field->name])) {
                $this->fields[$key]->setValue($global[$field->name]->value);
            }
        }
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        if (!empty(Query::$post['clearall'])) {
            $values = NodeSettingValue::getList(
                array('filters' => array('node <> 0', sprintf('type="%s"', $this->module->type)))
            )->getItems();
            foreach ($values as $value) {
                $value->delete();
            }
        }
        $settings->update();
        $this->afterSaveItem();
    }

    protected function afterSaveItem()
    {
        Utils::redirect($this->pathPrefix . '/edit/' . $this->module->id);
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('fields', $this->fields);
        $tpl->assign('module', $this->module);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }


}