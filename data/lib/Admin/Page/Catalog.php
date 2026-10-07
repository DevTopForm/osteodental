<?php

namespace App\Admin\Page;

use App\Control\Element;
use App\Node\Item;
use App\Node\Setting\Value;
use App\Query;
use App\Registry;
use App\Utils;
use App\Item\Catalog as ItemCatalog;
use App\Control\Filter\Node as FilterNode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Item\History as ItemHistory;

class Catalog extends LAVED
{
    protected $localTpl = 'content/catalog.tpl';
    protected $action = 'catalog';

    protected function getStateRegexps()
    {
        return [
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+\/\-?\d+$/i',
            self::STATE_ADD => '/^add\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+\/\d+$/i',
        ];
    }

    protected function getItem()
    {
        $item = new Item($this->node->getTable(), $this->extractItemId());
        return $item;
    }

    protected function getItemsList()
    {
        //return $this->node->getItems($this->getParameters(),25);
    }

    //новое обновление c laminas
    protected function updateDbCatalog($data, $table, $where)
    {
        $db = Registry::get('db');
        $update = $db->sql->update();
        $update->table($table);
        $update->set($data);
        $update->where($where);
        $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
    }

    protected function updateProducts($data, $ids): void
    {
        $db = Registry::get('db');

        foreach ($ids as $id) {
            $item = $db->query(
                sprintf('SELECT * FROM `content_catalog` WHERE `id`=%s', $id),
                $db::QUERY_MODE_EXECUTE
            )->toArray();

            if ($item[0]["id"]) {
                $properties = json_decode($item[0]["properties"], true);
                foreach ($data as $field => $value) {
                    $properties[$field] = $value;
                }

                $update = $db->sql->update();
                $update->table("content_catalog");
                $update->set(["properties" => json_encode($properties, JSON_UNESCAPED_UNICODE)]);
                $update->where("id = $id");
                $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
            }
        }
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        if (!empty(Query::$post['listaction'])) {
            if (empty(Query::$post['list'])) {
                Utils::redirectPrevious();
            }

            $db = Registry::get('db');
            switch (Query::$post['listaction']) {
                case "export":
                    $ids = implode(',', Query::$post['list']);
                    $items = $db->query(
                        'SELECT * FROM `content_catalog` WHERE id IN(' . $ids . ')',
                        $db::QUERY_MODE_EXECUTE
                    )->toArray();
                    foreach ($items as $itemKey => $itemValue) {
                        $node = new Node($itemValue['node']);
                        $items[$itemKey]['node'] = $node->title;
                    }
                    $this->makeExport($items);
                    break;
                case "public":
                    $ids = implode(',', Query::$post['list']);
                    if (!empty($ids)) {
                        $data = ['public' => 1];
                        $where = sprintf('id IN (%s)', $ids);
                        $this->updateDbCatalog($data, 'content_catalog', $where);
                    }
                    break;
                case "public_clear":
                    $ids = implode(',', Query::$post['list']);
                    if (!empty($ids)) {
                        $data = ['public' => 0];
                        $where = sprintf('id IN (%s)', $ids);
                        $this->updateDbCatalog($data, 'content_catalog', $where);
                    }
                    break;
                case "brand":
                    $brand = (int)Query::$post['brand'];
                    if (!empty($brand)) {
                        $this->updateProducts(['brand' => $brand], Query::$post['list']);
                    }
                    break;
                case "category":
                    $category = (int)Query::$post['category'];
                    if (!empty($category)) {
                        $ids = implode(',', Query::$post['list']);
                        if (!empty($ids)) {
                            $data = ['node' => $category];
                            $where = sprintf('id IN (%s)', $ids);
                            $this->updateDbCatalog($data, 'content_catalog', $where);
                        }
                    }
                    break;
                case "analogs_block":
                    $analogs = implode(",", Query::$post['analogs']);
                    if (!empty($analogs)) {
                        $this->updateProducts(['products' => $analogs], Query::$post['list']);
                    }
                    break;
                case "category_advance":
                    $category = (int)Query::$post['advanced_category'];
                    if (!empty($category)) {
                        $nodeParam = Value::getByKeys(["node" => $category, "name" => "products"]);

                        $ids = [];
                        $idsList = Query::$post['list'];
                        foreach ($idsList as $id) {
                            $id = (int)$id;
                            if (!empty($id)) {
                                $ids[] = $id;
                            }
                        }
                        if (!empty($nodeParam->id) && !empty($ids)) {
                            $relatedItemsIds = explode(",", $nodeParam->value);

                            foreach ($ids as $itemId) {
                                if (!in_array($itemId, $relatedItemsIds)) {
                                    $relatedItemsIds[] = $itemId;
                                }
                            }

                            $data = ['value' => implode(",", $relatedItemsIds)];
                            $where = sprintf('id =%s', $nodeParam->id);
                            $this->updateDbCatalog($data, 'nodes_params_values', $where);
                        }
                    }
                    break;
                default:
                    break;
            }
            ItemHistory::add("Групповые операции", "/adm/catalog");
            Utils::redirectPrevious();
        }

        $filterParams = $this->getParameters();
        if (!empty(Query::$get['catalog_filter'])) {
            $arID = [];
            unset($filterParams['filters']['variant']);
            $preResult = ItemCatalog::getList($filterParams)->getItems();
            if (!empty($preResult)) {
                foreach ($preResult as $itemResult) {
                    $arID[] = $itemResult->id;
                }
                $filterParams['filters'] = ["id IN(" . implode(',', $arID) . ")"];
            } else {
                $filterParams['filters'] = ["id = 0"];
            }
            //$filterParams['filters'][] = 'variant = 0';

            $allCatalogIds = ItemCatalog::getIdCatalogList($filterParams);//все id выбранных элементов в фильтре
        }

        $pager = Query::$get["pager"] ? (Query::$get["pager"] === "all" ? null : Query::$get["pager"]) : 10;
        $rs = ItemCatalog::getList($filterParams, $pager);
        $items = $rs->getItems();
        if (!empty($items)) {
            //$this->getVariants($items);
            $tagIds = [];
            $keys = [
                'vozrast',
                'vkus',
                'poroda',
                'kategorii_kormov',
                'tip_tovara',
                'naznachenie',
                'linejjka',
                'vid',
                'vdz',
                'cvet',
                'razmer',
                'material',
                'profilaktika',
                'dopolnitelno',
                'volume',
                'mass',
                'krasota'
            ];

            if (!empty($tagIds)) {
                $tags = [];
                Item::$itemsTable = 'content_tag';
                $tagsList = Item::getList(['filters' => [sprintf('id IN (%s)', join(',', $tagIds))]]
                )->getItems();
                foreach ($tagsList as $tag) {
                    $tags[$tag->id] = $tag;
                }
                foreach ($items as $k => $item) {
                    if (!empty($item->variantItems)) {
                        foreach ($item->variantItems as $keyV => $variant) {
                            foreach ($keys as $key) {
                                $akey = $key . '_a';
                                if (!empty($items[$k]->variantItems[$keyV][$akey])) {
                                    $array = [];
                                    foreach ($items[$k]->variantItems[$keyV][$akey] as $tk => $value) {
                                        if (!empty($tags[$value])) {
                                            $array[$tk] = $tags[$value]['title'];
                                        }
                                    }
                                    $items[$k]->variantItems[$keyV][$akey] = $array;
                                }
                            }
                        }
                    }
                    foreach ($keys as $key) {
                        $akey = $key . '_a';
                        if (!empty($items[$k]->$akey)) {
                            $array = [];
                            foreach ($items[$k]->$akey as $tk => $value) {
                                if (!empty($tags[$value])) {
                                    $array[$tk] = $tags[$value]->title;
                                }
                            }
                            $items[$k]->$akey = implode(', ', $array);
                        }
                    }
                }
                $rs->setItems($items);
            }

            foreach ($items as &$item) {
                if (!empty($item->brand)) {
                    Item::$itemsTable = 'content_';
                    $item->brand = new Item("content_list", $item->brand);
                }
            }
        }
        if (isset($allCatalogIds)) {
            $tpl->assign('allIds', $allCatalogIds);
        }
        $tpl->assign('list', $items);
        $tpl->assign('data', $this->getSpecialListData());
        $tpl->assign('filters', $this->getFiltersHtml());
        $tpl->assign('filtersVanila', $this->filters);
        $tpl->assign('pager', $rs->getPager()->getHTML(true));
        return $tpl->fetch($this->localTpl);
    }

    protected function getVariants(&$items)
    {
        $parentsId = [];
        foreach ($items as $item) {
            $parentsId[] = $item->id;
        }
        Item::$itemsTable = 'content_catalog';
        $childrens = Item::getList(
            ['filters' => ['variant IN(' . implode(',', $parentsId) . ')'], 'sorters' => 'title ASC']
        )->getItems();
        $arChildrens = [];
        foreach ($childrens as $child) {
            $arChildrens[$child->variant][] = $child;
        }

        foreach ($items as &$item) {
            if (!empty($arChildrens[$item->id])) {
                $item->childrens = $arChildrens[$item->id];
            }
        }
        unset($item);
        return;
    }

    protected function getParents(&$items)
    {
        $parentsId = [];
        $childrens = [];
        foreach ($items as $key => $item) {
            if ($item->variant > 0) {
                $parentsId[] = $item->variant;
                $childrens[$item->variant][] = $item;
                unset($items[$key]);
            }
        }

        Item::$itemsTable = 'content_catalog';
        $parents = Item::getList(
            ['filters' => ['id IN(' . implode(',', $parentsId) . ')'], 'sorters' => 'title ASC']
        )->getItems();
        $arParents = [];
        foreach ($parents as $parent) {
            $parent->childrens = $childrens[$parent->id];
            $items[] = $parent;
            //$arChildrens[$child->variant][] = $child;
        }

        return;
    }

    protected function getSpecialListData()
    {
        $data = [];
        $tree = new FilterNode('node', 'Категория');
        $data['tree'] = $tree->tree;
        $advanced = new FilterNode('selection', 'Сборная', "catalog", true);
        $data['advanced'] = $advanced->tree;
        Item::$itemsTable = 'content_catalog';
        $items = Item::getList(['filters' => ['public=1'], 'sorters' => ['title ASC']])->getItems();;
        $data['analogs'] = $this->getMultiselectHtml("analogs_block", 'analogs', $items);
        Item::$itemsTable = 'content_list';
        $data['brands'] = Item::getList(['filters' => ['node = 4196'], 'sorters' => ['title ASC']])->getItems();
        return $data;
    }

    public function getMultiselectHtml($id, $name, $items)
    {
        $options = "";
        foreach ($items as $option) {
            $options .= sprintf('<option value="%s">%s</option>', $option->id, addslashes($option->title));
        }

        $result = sprintf(
            '
            <div class="groups-actions__item" data-block="%s">
                <div class="label">
                    <span class="label__name">Выберите:</span>
                    <div class="js-multiselect" id="%s">
                        <select multiple="" class="select" name="%s[]">
                            %s
                        </select>
                    </div>
                </div>
            </div>',
            $id,
            $id,
            $name,
            $options
        );

        return $result;
    }

    protected function getParameters()
    {
        $parameters = [
            'filters' => $this->getListFilters(),
            'sorters' => $this->getListSorters()
        ];
        $this->countFilters = [];

        if (!empty(Query::$get["title"])) {
            $s = Query::$get["title"];
            $parameters["filters"][] = "(`title` LIKE '%$s%' OR `text` LIKE '%$s%')";
        }
        foreach ($parameters['filters'] as $key => $filter) {
            if ($filter instanceof Element) {
                $this->countFilters[$key] = $filter->getFilterSQL();
            } else {
                $this->countFilters[$key] = $filter;
            }
        }
        $this->filters = $this->prepareFilters($parameters);
        return $parameters;
    }

    protected function getListSorters()
    {
        return ['title ASC'];
    }

    protected function getListFilters()
    {
        $filters = [
            //'variant' => 'variant = 0',
            //'id not in (select variant from content_catalog where variant > 0)',
            'node' => new FilterNode('node', 'Категория'),
            'category_advance' => new FilterNode('selection', 'Сборная категория', 'catalog', true),
        ];
        return $filters;
    }

    protected function getFiltersHtml()
    {
        $filters = [];
        foreach ($this->filters as $key => $filter) {
            if ($filter instanceof Element) {
                $filters[$key] = $filter->getHTML();
            } else {
                $filters[$key] = $filter;
            }
        }
        return $filters;
    }

    protected function prepareFilters($parameters = [])
    {
        $filters = [];
        foreach ($parameters as $group) {
            foreach ($group as $key => $filter) {
                $filters[$key] = $filter;
            }
        }
        foreach ($filters as $key => $filter) {
            foreach ($filters as $bindFilter) {
                if ($filter instanceof Element && $filter !== $bindFilter) {
                    $filters[$key]->bindWith($bindFilter);
                }
            }
        }
        return $filters;
    }

    protected function makeExport($items = [])
    {
        if (!empty($items)) {
            $db = Registry::get('db');
            //получаем поля модуля
            $fieldsBase = $db->query(
                'SELECT `name`,`title` FROM `nodes_fields` WHERE `type` = "catalog"',
                $db::QUERY_MODE_EXECUTE
            )->toArray();
            //преобразуем их для легкого поиска
            $fields = [];
            foreach ($fieldsBase as $fieldKey => $fieldValue) {
                if ($fieldValue == 'id') {
                    $fields['id'] = 'id';
                } elseif ($fieldValue == 'node') {
                    $fields['node'] = 'Раздел';
                } else {
                    $fields[$fieldValue['name']] = $fieldValue['title'];
                }
            }

            $xls = new Spreadsheet();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $row = 1;
            $col = 0;
            foreach ($items[0] as $etalonKey => $etalonValue) {
                $xls->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $fields[$etalonKey]);
                $col++;
            }
            $row = 2;
            foreach ($items as $item) {
                $col = 0;
                foreach ($item as $itemKey => $itemValue) {
                    $xls->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $itemValue);
                    $col++;
                }
                $row++;
            }

            $writer = new Xlsx($xls);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . urlencode("export.xlsx") . '"');
            $writer->save('php://output');

            exit();
        }
    }
}
