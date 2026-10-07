<?php

namespace App\Admin\Page;

use App\Node as AppNode;
use App\Node\Item;
use App\Node\Group;
use App\Node\Variant\Item as VariantItem;
use App\Node\Catalog\Item as CatalogItem;
use App\Node\History;
use App\Query;
use App\Registry;
use App\Utils;
use App\Item\History as ItemHistory;
use App\Item\Favorite as ItemFavorite;

class Content extends NodeLAVED
{

    protected $localTpl = 'content/content.tpl';
    protected string $historyTable = 'element_temp_storage';
    protected array $fields = [];
    protected array $all_fields = [];
    protected array $catalogFields = [];
    protected array $variantFields = [];
    protected string $variantAction = 'list';
    protected $variants;
    protected bool $isCatalog = false;

    const STATE_VARIANT_NEW = 'variantNew';
    const STATE_VARIANT_EDIT = 'variantEdit';

    protected function getStateRegexps()
    {
        return [
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_VARIANT_NEW => '/^variant\/\d+$/i',
            self::STATE_VARIANT_EDIT => '/^variant\/\d+\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+\/\d+$/i',
            self::STATE_ADD => '/^add\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+\/\d+$/i',
        ];
    }

    protected function executeRequestProcessing()
    {
        $this->node = new AppNode(@intval($this->parts[3]));
        $this->isCatalog = !empty($this->node->type->is_catalog);
        if (empty($this->node->id)) {
            Utils::redirect($this->admPath);
        }
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_LIST) {
            $this->deleteItems();
            $this->copyItems();
        }

        if ($this->state == self::STATE_VARIANT_NEW || $this->state == self::STATE_VARIANT_EDIT) {
            $this->variantsHandler();
        }
    }

    protected function extractItemId()
    {
        return @intval($this->parts[4]);
    }

    protected function getVariantId()
    {
        if (!empty(Query::$post['variant'])) {
            return Query::$post['variant'];
        }
        return null;
    }

    protected function getItem()
    {
        if ($this->isCatalog) {
            return new CatalogItem($this->node->getTable(), $this->extractItemId());
        }

        return new Item($this->node->getTable(), $this->extractItemId());
    }

    protected function getItemsList()
    {
        return $this->node->getItems($this->getParameters(), $this->getLimit());
    }

    protected function setItemFields()
    {
        $this->item->node = empty($this->item->node) ? $this->node : $this->item->node;
        $this->item->setFields($this->fields);
    }

    protected function setItemCatalogFields()
    {
        $this->item->node = empty($this->item->node) ? $this->node : $this->item->node;
        $this->item->setFields($this->catalogFields);
    }

    protected function setVariantFields()
    {
        $this->variant->node = empty($this->variants->node) ? $this->node : $this->item->node;
        $this->variant->setFields($this->variantFields);
    }

    protected function deleteItems()
    {
        if (empty(Query::$post) || empty(Query::$post['list']) || empty(Query::$post['delete'])) {
            return;
        }

        foreach (Query::$post['list'] as $id => $val) {
            $item = new Item($this->node->getTable(), $id);
            $item->delete();
        }

        Utils::redirectPrevious();
    }

    protected function copyItems()
    {
        if (empty(Query::$post) || empty(Query::$post['list']) || empty(Query::$post['copy'])) {
            return;
        }

        if (!empty(Query::$post['list']) && !empty(Query::$post['copy'])) {
            foreach (Query::$post['list'] as $id => $val) {
                $item = $this->node->type->is_catalog ? new AppNode\Catalog\Item($this->node->getTable(), $id) : new Item($this->node->getTable(), $id);
                if ($item->validate()) {
                    $item->id = null;
                    $item->save();
                }
            }
        }
        Utils::redirectPrevious();
    }

    protected function editItem()
    {
        if (!empty(Query::$post['history_return']) || !empty(Query::$post['history_save'])) {
            $this->item = $this->historyReturn($this->extractItemId());
        } else {
            $this->item = $this->getItem();
        }

        if (!empty($this->item->id) && $this->item->node->id != $this->node->id) {
            Utils::redirect($this->pathPrefix . '/edit/' .  $this->item->node->id . '/' . $this->item->id);
        }

        $params = $this->node->getParams();
        $this->fields = $this->node->getFields();

        $this->item->node = $this->node;

        if ($this->isCatalog) {
            $this->catalogFields = $this->node->getCatalogFields();
        }

        foreach ($this->fields as $key => $field) {
            if ($field->name != 'title') {
                continue;
            }

            $name = $field->name;

            if (!empty($item->$name)) {
                $params['file_title'] = $item->$name;
            }

            if (isset(Query::$post['save']) && !empty(Query::$post[$field->name])) {
                $params['file_title'] = Query::$post[$field->name];
            }

            break;
        }

        foreach ($this->fields as $key => $field) {
            $field->setParams($params);
            $name = $field->name;
            $field->setValue(empty($this->item->$name) ? '' : $this->item->$name);
            $this->fields[$key] = $field;
        }

        if ($this->isCatalog) {
            foreach ($this->catalogFields as $key => $field) {
                $field->setParams($params);
                $name = $field->name;
                $field->setValue(empty($this->item->$name) ? '' : $this->item->$name);
                $this->catalogFields[$key] = $field;
            }
        }

        if (!empty(Query::$post['copy_item'])) {
            $this->setItemFields();
            $this->setItemCatalogFields();
            if ($this->item->validate()) {
                $this->item->id = null;
                $this->item->save();
                $this->afterSaveItemApply();
            }
        }

        if (isset(Query::$post['favorite'])) {
            if (!empty($this->item->id)) {
                $url = "/adm/content/edit/" . $this->node->id . "/" . $this->item->id;
            }

            if (Query::$post['favorite']) {
                ItemFavorite::add($this->item->title ?: $this->node->id . "-" . $this->item->id, $url);
            } else {
                ItemFavorite::findAndDelete($url);
            }
        }

        if (!empty(Query::$post['delete'])) {
            $this->item->delete();
            $this->afterDeleteItem();
        }

        if (empty(Query::$post['save']) && empty(Query::$post['save_item'])) {
            return;
        }

        $this->setItemFields();
        $this->setItemCatalogFields();

        if ($this->item->validate()) {
            if (empty(Query::$post['history_save']) && !empty($this->item->id)) {
                $this->saveHistory();
            }
            $this->item->save();

            if ($this->node->type->has_variants) {
                $this->variantUpdate();
            }

            if (!empty(Query::$post['save_item'])) {
                $this->afterSaveItemApply();
            } else {
                $this->afterSaveItem();
            }
        } else {
            foreach ($this->fields as $key => $field) {
                $field->setQueryValue();
                $this->fields[$key] = $field;
            }

            if ($this->isCatalog) {
                foreach ($this->catalogFields as $key => $field) {
                    $field->setQueryValue();
                    $this->catalogFields[$key] = $field;
                }
            }
        }
    }

    public function saveHistory()
    {
        $data = [];
        foreach ($this->item as $key => $field) {
            if (is_array($field)) {
                continue;
            }

            if ($key == 'node') {
                $field = $field->id;
            }

            $data[$key] = $field;
        }

        $info = json_encode($data);
        $data = [
            'element_id' => $this->item->id,
            'data' => $info
        ];
        $db = Registry::get('db');
        $item = $db->query(
            sprintf("SELECT * FROM %s WHERE %s", $this->historyTable, 'element_id=' . $this->item->id)
        )->execute()->current();
        if ($item) {
            $update = $db->sql->update();
            $update->table($this->historyTable);
            $update->set($data);
            $update->where('element_id=' . $this->item->id);
            $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        } else {
            $insert = $db->sql->insert();
            $insert->into($this->historyTable);
            $insert->columns(array_keys($data));
            $insert->values($data);
            $db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
            $this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();
        }
        //$this->updateCache();
    }

    protected function historyReturn($element_id)
    {
        $item = new History($this->node->getTable(), $element_id);
        $item->getItem();
        return $item;
    }

    protected function afterSaveItem()
    {
        ItemHistory::add($this->item->title ?: $this->node->id . "-" . $this->item->id, $_SERVER['REQUEST_URI']);
        Utils::redirect($this->pathPrefix . '/list/' . $this->node->id);
    }

    protected function afterSaveItemApply()
    {
        ItemHistory::add($this->item->title ?: $this->node->id . "-" . $this->item->id, $_SERVER['REQUEST_URI']);
        Utils::redirect($this->pathPrefix . '/edit/' . $this->node->id . '/' . $this->item->id);
    }

    protected function afterDeleteItem()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(
            ['redirect' => $this->pathPrefix . '/list/' . $this->node->id]
        );
        die();
    }

    protected function afterSaveVariant()
    {
        if (empty($this->item->id)) {
            $this->item->id = 0;
        }
        $this->localTpl = "content/variants/list.tpl";
        $tpl = $this->getItemsTpl();
        $this->getVariantsList();
        $tpl->assign('item', $this->item);
        $tpl->assign('node', $this->node);
        $tpl->assign('variants', $this->variants);
        $tpl->assign('variantFields', $this->variantFields);
        $tpl->display($this->localTpl);
        die;
    }

    protected function afterSaveVariantApply()
    {
        Utils::redirect($this->pathPrefix . '/edit/' . $this->node->id . '/' . $this->item->id);
    }

    protected function afterDeleteVariant()
    {
        Utils::redirect($this->pathPrefix . '/list/' . $this->node->id);
    }

    protected function getSpecialListData()
    {
        return [];
    }

    protected function getListSorters()
    {
        if ($this->isCatalog) {
            return ["sorter ASC"];
        }

        $sorters = [];

        foreach ($this->all_fields ?? [] as $field) {
            if (!empty($field->sorter)) {
                $sorters[] = sprintf('%s %s', $field->name, ($field->sorter == 1) ? 'ASC' : 'DESC');
            }
        }
        return $sorters;
    }

    protected function prepareList($rs)
    {
        $items = $rs->getItems();
        $fields = $this->fields["text"] ?: $this->fields;

        foreach ($items as $ik => $item) {
            foreach ($fields as $field) {
                $name = $field->name;
                if (isset($item->$name)) {
                    $item->$name = $field->prepareValue($item->$name);
                }
            }
            $items[$ik] = $item;
        }
        $rs->setItems($items);
        return $rs;
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        if (!empty($this->node->type->has_items)) {
            $params = $this->node->getParams();


            if ($this->isCatalog) {
                $this->catalogFields = $this->node->getCatalogFields();
                foreach ($this->catalogFields as $key => $field) {
                    $this->catalogFields[$key]->setParams($params);
                }
            }

            $this->fields = $this->all_fields = $this->node->getFields();
            foreach ($this->fields as $key => $field) {
                $this->fields[$key]->setParams($params);
            }

            if ($this->catalogFields) {
                $this->fields = array_merge($this->fields, $this->catalogFields);
            }

            $this->fields = $this->getShowFields($this->fields);
            $items = $this->prepareList($this->getItemsList());
            $countChange = $this->getCountList($items->getTotal());
            $tpl->assign('node', $this->node);
            $tpl->assign('fields', $this->fields);
            $tpl->assign('count', $_SESSION['node-items-count']);
            if (!is_null($items)) {
                $tpl->assign('list', $items->getItems());
                $tpl->assign('countChange', $countChange);
                $tpl->assign('total', $items->getTotal());
                $tpl->assign('filters', $this->getFiltersHtml());
                $items->getPager()->bindWith($this->filters);
                $tpl->assign('pager', $items->getPager()->getHTML(true));
                $tpl->assign('perpage', $items->getPager()->getPerPage());
            }
            $tpl->assign('data', $this->getSpecialListData());
            return $tpl->fetch($this->localTpl);
        } elseif (!empty($this->node->type->has_content)) {
            $items = $this->prepareList($this->getItemsList());
            $items = $items->getItems();
            $item = array_shift($items);
            Utils::redirect(
                $this->pathPrefix . (empty($item) ? ('/add/' . $this->node->id) : ('/edit/' . $this->node->id . '/' . $item->id))
            );
        } else {
            $tpl->assign('node', $this->node);
            return $tpl->fetch($this->localTpl);
        }
    }

    protected function parseStateAdd()
    {
        if (!$this->node->type->has_items) {
            $items = $this->prepareList($this->getItemsList());
            $items = $items->getItems();
            if (!empty($items)) {
                $item = array_shift($items);
                Utils::redirect($this->pathPrefix . '/edit/' . $this->node->id . '/' . $item->id);
            }
        }
        return $this->parseStateEdit();
    }

    protected function parseStateEdit()
    {
        $groups = $this->prepareGroups($this->fields);

        if ($this->isCatalog) {
            $groups = array_merge($groups, $this->prepareGroups($this->catalogFields, false));
        }

        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('groups', $groups);
        $tpl->assign('node', $this->node);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function parseStateVariantNew()
    {
        $this->parseStateVariantEdit();
    }

    protected function parseStateVariantEdit()
    {
        $this->localTpl = "content/variants/$this->variantAction.tpl";
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->item);
        $tpl->assign('node', $this->node);
        if (!empty($this->variant)) {
            $tpl->assign('variant', $this->variant);
        }
        $tpl->assign('variants', $this->variants);
        $tpl->assign('variantFields', $this->variantFields);
        if (!empty(Query::$post['ajax'])) {
            $tpl->display($this->localTpl);
            die;
        }
        return $tpl->fetch($this->localTpl);
    }

    protected function defineVariantAction()
    {
        if (!empty(Query::$post['action'])) {
            $this->variantAction = Query::$post['action'];
        }
    }

    protected function variantsHandler()
    {
        $this->defineVariantAction();
        $this->item = $this->getItem();
        $this->variant = new VariantItem('content_catalog_variant', $this->getVariantId());
        $this->variant->item = $this->item;
        if (!empty($this->variant->id)) {
            $this->variant->setItem($this->item);
        }

        if ($this->variantAction == 'list') {
            $this->getVariantsList();
        }
        $this->getVariantFields();
        if (!empty(Query::$post['apply_variant']) || !empty(Query::$post['save_variant'])) {
            $this->variantSave();
        }

        if (!empty(Query::$post['remove'])) {
            $this->variantRemove();
        }
    }

    protected function getVariantFields()
    {
        $this->variantFields = $this->node->getVariantFields();
        $params = $this->node->getParams();
        foreach ($this->variantFields as $key => $field) {
            $field->setParams($params);
            $name = $field->name;
            $field->setValue(empty($this->variant->$name) ? '' : $this->variant->$name);
            $this->variantFields[$key] = $field;
        }
    }

    protected function getVariantsList()
    {
        $item = empty($this->item->id) ? 0 : $this->item->id;
        $this->variants = Node_Variant_Item::getList(['filters' => ['item=' . $item]])->getItems();
    }

    protected function variantSave()
    {
        $this->setVariantFields();
        if ($this->variant->validate()) {
            $this->variant->save();
            if (!empty(Query::$post['apply_variant'])) {
                $this->afterSaveVariantApply();
            } else {
                $this->afterSaveVariant();
            }
        } else {
            foreach ($this->fields as $key => $field) {
                $field->setQueryValue();
                $this->fields[$key] = $field;
            }
        }
    }

    protected function variantRemove()
    {
        $this->variant->node = $this->node;
        $this->variant->delete();
        $this->afterSaveVariant();
    }

    protected function variantUpdate()
    {
        $variantObject = new Node_Variant_Item($this->node->getTable() . '_variant');
        $variantObject->item = $this->item;
        $variantObject->update();
    }

    protected function getListFilters()
    {
        $filter = [
            'node' => sprintf('node = %d', $this->node->id)
        ];

        if (!empty(Query::$get['search_text'])) {
            //$filter['title'] = "title LIKE '%".Query::$get['search_text']."%' OR naimenovanie LIKE '%".Query::$get['search_text']."%' OR artikul LIKE '%".Query::$get['search_text']."%' OR brend LIKE '%".Query::$get['search_text']."%'";
            $filter['title'] = "title LIKE '%" . Query::$get['search_text'] . "%'";
        }
        return $filter;
    }

    protected function getCountList($total)
    {
        $countList = [
            [
                'name' => 20,
                'value' => 20
            ],
            [
                'name' => 50,
                'value' => 50
            ],
            [
                'name' => 100,
                'value' => 100
            ],
            [
                'name' => 'Все',
                'value' => 'all'
            ]
        ];
        if ($total > 2000) {
            unset($countList[3]);
        }

        return $countList;
    }

    private function getShowFields($fields = [])
    {
        $result = [
            'text' => [],
            'checkbox' => [],
        ];

        if (empty($fields)) {
            return $result;
        }

        foreach ($fields as $field) {
            if (empty($field->show) || $field->name == 'public') {
                continue;
            }

            $result[$field->field == 'checkbox' ? 'checkbox' : 'text'][] = $field;
        }

        return $result;
    }

    public function prepareGroups($fields, $isMain = true)
    {
        $fieldsGroups = [
            0 => [
                'title' => !empty($this->isCatalog && $isMain) ? 'Основные поля товара' : 'Поля без группы',
                'fields' => [],
                'weight' => -1
            ]
        ];

        foreach ($fields as $field) {
            if (!empty($this->item->errors[$field->name])) {
                $field->errorsMessage = strip_tags(
                    $this->item->errors[$field->name]->html ?: $this->item->errors[$field->name]
                );
            }

            if (!empty($field->node_group)) {
                if (empty($fieldsGroups[$field->node_group])) {
                    $group = Group::getByKey('id', $field->node_group);
                    $fieldsGroups[$group->id] = [
                        'title' => $group->title,
                        'fields' => [],
                        'weight' => $group->weight
                    ];
                }

                $fieldsGroups[$field->node_group]['fields'][] = $field;
            } else {
                $fieldsGroups[0]['fields'][] = $field;
            }
        }

        if (empty($fieldsGroups[0]['fields'])) {
            unset($fieldsGroups[0]);
        }

        usort($fieldsGroups, function ($a, $b) {
            if ($a['weight'] == $b['weight']) {
                return 0;
            }
            return ($a['weight'] < $b['weight']) ? -1 : 1;
        });

//        pre($fieldsGroups);
        return $fieldsGroups;
    }

}
