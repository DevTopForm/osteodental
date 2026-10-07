<?php

namespace App\Admin\Page;

use App\Item\History as ItemHistory;
use App\Query;
use App\Site\Setting;
use App\Site\Setting\Item;
use App\Site\Field\Item as SiteFieldItem;
use App\Node\Field\Item as NodeFieldItem;
use App\Utils;

class Settings extends LAVED
{

    protected $localTpl = 'content/settings.tpl';

    protected $defaultState = 'edit';
    protected $action = 'settings';
    protected $fields = [];

    protected function getStateRegexps()
    {
        return array(
            self::STATE_EDIT => '/^edit$/i',
            self::STATE_ADD => '/^add$/i',
            self::STATE_IMAGES => '/^images$/i',
        );
    }

    protected function executeRequestProcessing()
    {
        if ($this->state == self::STATE_EDIT || $this->state == self::STATE_IMAGES) {
            $this->editItem();
        }
        if ($this->state == self::STATE_ADD) {
            $this->addItem();
            $this->editItem();
        }
    }

    protected function setItemFields($values = array())
    {
        foreach ($this->fields as $key => $field) {
            $messages = $field->validate();
            if (!empty($messages)) {
                $valid = false;
                $this->errors = array_merge($this->errors, $messages);
            } else {
                if (isset($values[$field->name])) {
                    $value = $values[$field->name];
                } else {
                    $value = new Item();
                    $value->name = $field->name;
                }
                $value->value = $field->getValue();
                $value->save();
            }
            $this->fields[$key] = $field;
        }
    }

    protected function setItemAddFields()
    {
        $this->item->title = strip_tags(Query::$post['title']);
        $this->item->name = Utils::translit(strip_tags(Query::$post['name']));
        $this->item->field = strip_tags(Query::$post['field']);
    }

    protected function addItem()
    {
        $this->action = "settingsdop";

        $this->item = $this->getAddItem();
        $settings = new Setting();
        $this->fields = $settings->getFields(array('filters' => array('`show` = 1')));

        if (empty(Query::$post['save'])) {
            return;
        }

        $this->setItemAddFields();
        if ($this->item->validate()) {
            $this->item->save();
            $this->afterSaveItem();
        }
    }

    protected function editItem()
    {
        if ($this->state == self::STATE_IMAGES) {
            $this->action = "settingsimages";
        }

        $this->item = $this->getItem();
        $settings = new Setting();
        $this->fields = $settings->getFields(array('filters' => array('`show` = 1')));
        $values = Item::get('assoclist');
        foreach ($this->fields as $key => $field) {
            if ($field->field == 'image') {
            }

            if (isset($values[$field->name])) {
                $this->fields[$key]->setValue($values[$field->name]->value);
            }
        }
        if (empty(Query::$post['save'])) {
            return;
        }

        if (!empty(Query::$post['remove']) && count(Query::$post['remove']) > 0) {
            $keys = array_keys(Query::$post['remove']);
            foreach ($keys as $rItem) {
                $id = intval($rItem);
                $settings->removeField($id);

                foreach ($this->fields as $key => $field) {
                    if ($field->id == $id) {
                        unset($this->fields[$key]);
                    }
                }
            }
        }

        $this->setItemFields($values);
        $settings->update();
        $this->afterSaveItem();
    }

    protected function getAddItem()
    {
        return new SiteFieldItem($this->extractItemId());
    }

    protected function getItem()
    {
        return null;
    }

    protected function getItemsList($archive = 0)
    {
        return array();
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Настройки", "/adm/settings");
        if ($this->state == self::STATE_EDIT) {
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Настройки", "/adm/settings");
        Utils::redirect($this->pathPrefix);
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('fields', $this->fields);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function getSpecialEditData()
    {
        return array(
            'types' => NodeFieldItem::$types,
        );
    }

}