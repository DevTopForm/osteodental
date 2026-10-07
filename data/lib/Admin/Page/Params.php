<?php

namespace App\Admin\Page;

use App\Item\History as ItemHistory;
use App\Node\Setting\Item as NodeSettingItem;
use App\Node as AppNode;
use App\Query;
use App\Registry;
use App\Node\Setting as NodeSetting;
use App\Site\Setting\Item as SiteSettingItem;
use App\Utils;

class Params extends LAVED
{

    protected $localTpl = 'content/params.tpl';

    protected $action = 'node';

    protected function getStateRegexps()
    {
        return array(
            self::STATE_EDIT => '/^edit\/\d+$/i',
        );
    }

    protected function setItemFields($values = [])
    {
        foreach ($this->fields as $key => $field) {
            $messages = $field->validate();
            if (!empty($messages)) {
                $this->errors = array_merge($this->errors, $messages);
            } else {
                if (isset($values[$field->name])) {
                    $value = $values[$field->name];
                } else {
                    $value = new NodeSettingItem();
                    $value->name = $field->name;
                    $value->node = $this->item->id;
                    $value->type = $this->item->getType();
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
        $this->item = $this->getItem();
        $this->fields = NodeSetting::getFieldsList(array('type' => $this->item->getType(), 'edit_in_node' => 1));
        $values = NodeSettingItem::get('assoclist', array('node' => $this->item->id, 'area' => 0));
        $global = SiteSettingItem::get('assoclist');
        $settings = Registry::get('settings');
        $params = $this->item->getParams();
        foreach ($this->fields as $key => $field) {
            $this->fields[$key]->setParams($params);
            if (isset($values[$field->name])) {
                $this->fields[$key]->setValue($values[$field->name]->value);
            } elseif (isset($global[$field->name])) {
                $this->fields[$key]->setValue($global[$field->name]->value);
            }
        }
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields($values);
        $settings->update();
        $this->afterSaveItem();
    }

    protected function getItem()
    {
        return new AppNode($this->extractItemId());
    }

    protected function getItemsList($archive = 0)
    {
        return [];
    }

    protected function afterSaveItem()
    {
        if (!empty($this->item->type->has_items)) {
            $url = "/adm/content/list/" . $this->item->id;
        } else {
            AppNode\Item::$itemsTable = "content_" . $this->item->type->type;
            $item = AppNode\Item::getByKey("node", $this->item->id);
            if (!empty($item->id)) {
                $url = "/adm/content/edit/" . $this->item->id . "/" . $item->id;
            }
        }

        ItemHistory::add($this->item->title, $url);
        Utils::redirect($this->pathPrefix . '/edit/' . $this->item->id);
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('fields', $this->fields);
        $tpl->assign('node', $this->item);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }


}