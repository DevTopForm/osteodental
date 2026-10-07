<?php

namespace App;

use App\Cabinet\LoginManager;
use App\Admin\LoginManager as AdminLoginManager;
use App\Module\Main;
use App\Node\Area as NodeArea;
use App\Node\Item;
use App\Node\Catalog\Item as CatalogItem;
use App\Node\Template as NodeTemplate;
use App\Site\Basket as SiteBasket;
use App\Site\Controller\Basket;
use App\Site\Controller\Checkout;
use App\Template as AppTemplate;
use App\Node\Type;
use App\Node\Type\Template as TypeTemplate;
use App\Site\Breadcrumb;
use App\Site\NotFound;
use App\Module\Model as ModuleModel;

class Node extends Model
{

    protected $table = 'nodes';
    protected $isCachable = false;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function prepareData()
    {
        if (!empty($this->template)) {
            $this->template = new NodeTemplate($this->template);
        }
        if (!empty($this->content_template)) {
            $this->content_template = new TypeTemplate($this->content_template);
        }

        if (!empty($this->type)) {
            $this->type = Type::getByKey('type', $this->type);
        }
        if (!empty($this->image)) {
            $this->image = new Image($this->image);
        }
        $this->menutitle = empty($this->menutitle) ? $this->title : $this->menutitle;
    }

    protected function getData()
    {
        $data = [
            'parent' => empty($this->parent) ? 0 : $this->parent,
            'title' => $this->title,
            'menutitle' => $this->menutitle,
            'image' => empty($this->image) ? 0 : $this->image->id,
            'public' => empty($this->public) ? 0 : 1,
            'template' => empty($this->template) ? 0 : $this->template->id,
            'content_template' => empty($this->content_template) ? 0 : $this->content_template->id,
            'weight' => empty($this->weight) ? 0 : $this->weight,
            'alias' => $this->alias,
            'redirect' => empty($this->redirect) ? '' : $this->redirect,
            'bread' => empty($this->bread) ? '' : $this->bread,
            'noindex' => empty($this->noindex) ? '' : $this->noindex,
            'canonical' => empty($this->canonical) ? '' : $this->canonical,
            'type' => empty($this->type) ? 0 : $this->type->type,
            'h1' => empty($this->h1) ? '' : $this->h1,
            'meta_title' => empty($this->meta_title) ? '' : $this->meta_title,
            'meta_keywords' => empty($this->meta_keywords) ? '' : $this->meta_keywords,
            'meta_description' => empty($this->meta_description) ? '' : $this->meta_description,
            'sitemap' => empty($this->sitemap) ? 0 : 1,
            'passworded' => empty($this->passworded) ? 0 : 1,
            'sadmin' => empty($this->sadmin) ? 0 : 1,
            'nomenu' => empty($this->nomenu) ? 0 : 1,
            'nosearch' => empty($this->nosearch) ? 0 : 1,
            'blocked' => empty($this->blocked) ? 0 : 1,
            'selection' => empty($this->selection) ? 0 : 1,
            'before_title' => empty($this->before_title) ? '' : $this->before_title,
            'before_text' => empty($this->before_text) ? '' : $this->before_text,
            'after_title' => empty($this->after_title) ? '' : $this->after_title,
            'after_text' => empty($this->after_text) ? '' : $this->after_text,
            'priority_node' => empty($this->priority_node) ? '' : $this->priority_node,
            'priority_element' => empty($this->priority_element) ? '' : $this->priority_element,
            'changefreq_node' => empty($this->changefreq_node) ? '' : $this->changefreq_node,
            'changefreq_element' => empty($this->changefreq_element) ? '' : $this->changefreq_element,
        ];
        return $data;
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->title)) {
            $valid = false;
            $this->messages[] = new Message('{$_LNG_ADM.TITLE_CANNOT_BE_EMPTY}', 'error');
        }
        if (empty($this->alias) && !empty($this->title)) {
            $this->generateAlias();
        } elseif (!preg_match('/^[0-9a-zA-Zа-яА-Я\-\_]+$/u', $this->alias)) {
            $valid = false;
            $this->messages[] = new Message('{$_LNG_ADM.WRONG_CHARACTERS_IN_ALIAS}', 'error');
        }
        if ($this->aliasExists()) {
            $valid = false;
            $this->messages[] = new Message('{$_LNG_ADM.ALIAS_EXISTS}', 'error');
        }
        return $valid;
    }

    public function aliasExists()
    {
        $item = static::getByKeys([
            'parent' => $this->parent,
            'alias' => $this->alias,
            '!id' => empty($this->id) ? 0 : $this->id
        ]);
        return !empty($item->id);
    }

    private function generateAlias()
    {
        $this->alias = Utils::translit($this->title);
        $prefix = 0;
        $alias = $this->alias;
        while ($this->aliasExists()) {
            $this->alias = sprintf('%s_%s', $alias, ++$prefix);
        }
    }

    public function getTable()
    {
        return $this->type->getTable();
    }

    public function getUrl()
    {
        if (!empty($this->redirect)) {
            $this->url = $this->redirect;
        } else {
            if (empty($this->url)) {
                $this->url = Structure::get_instance()->get_url($this->id);
            }
        }
        return $this->url;
    }

    public function display_ajax()
    {
        $mainModule = ModuleModel::factory($this->getType());
        try {
            $user = LoginManager::getLoggedUser();
        } catch (\Exception $e) {
            if ($this->isPassworded()) {
                $mainModule = ModuleModel::factory('password');
            }
        }
        $mainModule->node = $this;
        $mainModule->mainNode = $this;
        $mainModule->ajax = true;
        return $mainModule->getContent();
    }

    public function display()
    {
        $settings = Registry::get('settings');
        $params = array_merge(Params::$params['public'], $settings->getSiteParams());
        $params = $this->getImages(['logo', 'qr1', 'qr2', 'bottom_banner_image'], $params);
        $params = $this->getFiles(['file1', 'file2'], $params);

        if (!empty($params["favicon"]) && !is_object($params["favicon"])) {
            $params["favicon"] = new File($params["favicon"]);

            $favicon = sprintf('/favicon-%s.ico', $params['favicon']->id);

            if ($params["favicon"]->extension === "ico") {
                $params["favicon"] = new File($params["favicon"]->id);
                copy($_SERVER["DOCUMENT_ROOT"] . $params["favicon"]->getLink(), $_SERVER["DOCUMENT_ROOT"] . $favicon);
            } else {
                Utils::generateFavicon(
                    $_SERVER['DOCUMENT_ROOT'] . $params['favicon']->getLink(),
                    $_SERVER['DOCUMENT_ROOT'] . $favicon
                );
            }
        }

        $breadcrumbs = Breadcrumb::getInstance();
        $breadcrumbs->setNode($this);

        $this->tpl = new Template();
        if ($this->parent != 0 && !empty($this->parent)) {
            $this->parentNode = new Node($this->parent);
        }

        if (empty($this->image->id)) {
            $this->image = $this->getImageParent($this);
        }

        $this->tpl->assign('node', $this);

        $this->tpl->assign('query', Query::$request);
        $this->tpl->assign('params', $params);

        $this->tpl->assign('ld_json', json_encode([
            "@context" => "https://schema.org",
            "@type" => "MedicalOrganization",
            "name" => $params['sitename'],
            "url" => sprintf("https://%s" , $_SERVER['SERVER_NAME']),
            "logo" => $params['logo']->id ? $params['logo']->getLink() : '',
            "telephone" => $params['phone'],
            "email" => $params['email'],
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $params['address'],
                "addressLocality" => "Санкт-Петербург",
                "addressCountry" => "RU"
            ]
        ]));

        $basketTotal = SiteBasket::getInstance()->getTotal();
        $this->tpl->assign('basketCount', $basketTotal["count"]);


        $mainModule = ModuleModel::factory($this->getType());
        try {
            $this->tpl->assign('user', LoginManager::getLoggedUser());
        } catch (\Exception $e) {
            if ($this->isPassworded()) {
                $mainModule = ModuleModel::factory('password');
            }
        }

        $mainModule->node = $this;
        $mainModule->mainNode = $this;

        $areas = $this->getAreas();
        foreach ($areas as $nodeArea) {
            $area = new Area($nodeArea->area);

            if (!empty($nodeArea->object)) {
                $module = ModuleModel::factory($nodeArea->object->getType());
                $module->area = $nodeArea;
                $module->node = $nodeArea->object;
                $module->mainNode = $this;
                $content = $module->getContent();
                $mainModule->setBlock($area->alias, $content);
                $this->tpl->assign($area->alias, $content);
            }
        }

        if ($this->id === 4120) {
            $mainContent = Basket::fetchTemplate();
        } elseif ($this->id === 4122) {
             $mainContent = Checkout::fetchTemplate();
        } else {
            $mainContent = $mainModule->getContent();
        }

        try {
            $user = AdminLoginManager::getLoggedUser();
        } catch (\Exception $e) {
        }
        if (!empty($user->id) && !empty(Query::$get['url'])) {
            $btnStyles = [
                'position:fixed;',
                'top: 160px;',
                'right: 100px;',
                'background: #4159D2;',
                'color: #fff;',
                'padding: 12px 25px;',
                'font-weight: bold;',
                'border-radius: 4px;'
            ];

            $mainContent = sprintf(
                '<div style="position:relative;">
					<a title="Вы видите эту кнопку, потому что авторизованы в cms TopForm" target="_blank" style="%s" href="/adm/url/%s">Редактировать</a>
					%s 
				</div>',
                implode(' ', $btnStyles),
                Query::$get['url'],
                $mainContent
            );
        }

        $this->tpl->assign('content', $mainContent);
        //$this->tpl->assign('content', $mainModule->getContent());
        $this->tpl->assign('title', $mainModule->getTitle());


        $this->tpl->assign('favicon', $favicon);
        $this->tpl->assign('breadcrumbs', $breadcrumbs->parse());
        $this->tpl->display('page/' . (empty($this->template->file) ? 'index.tpl' : $this->template->file));
    }

    public function display_not_found()
    {
        $settings = Registry::get('settings');
        $params = array_merge(Params::$params['public'], $settings->getSiteParams());
        $this->meta_title = 'Страница не найдена';

        $params = $this->getImages(['logo', 'qr1', 'qr2'], $params);
        $params = $this->getFiles(['file1', 'file2'], $params);

        $this->tpl = new AppTemplate();
        if ($this->parent != 0 && !empty($this->parent)) {
            $this->parentNode = new Node($this->parent);
        }

        if (empty($this->image->id)) {
            $this->image = $this->getImageParent($this);
        }

        $this->tpl->assign('node', $this);

        $this->tpl->assign('query', Query::$request);
        $this->tpl->assign('params', $params);

        $basketTotal = SiteBasket::getInstance()->getTotal();
        $this->tpl->assign('basketCount', $basketTotal["count"]);

        $areas = $this->getAreas();
        foreach ($areas as $nodeArea) {
            $area = new Area($nodeArea->area);

            if (!empty($nodeArea->object)) {
                $module = ModuleModel::factory($nodeArea->object->getType());
                $module->area = $nodeArea;
                $module->node = $nodeArea->object;
                $module->mainNode = $this;
                $this->tpl->assign($area->alias, $module->getContent());
            }
        }

        $notFound = NotFound::getInstance();
        $this->tpl->display('page/404.tpl');
    }

    public function getParentNode()
    {
        if (empty($this->parent)) {
            return null;
        }
        return new Node($this->parent);
    }

    public function isPassworded()
    {
        if (!empty($this->passworded)) {
            return true;
        }
        $parent = $this->getParentNode();
        if (!empty($parent)) {
            return $parent->isPassworded();
        }
        return false;
    }

    public function getContent()
    {
        return $this->title;
    }

    public function getType()
    {
        if (!is_object($this->type)) {
            $this->type = unserialize($this->type);
        }
        return $this->type->type;
    }

    public function hasContent()
    {
        return !empty($this->type->has_content);
    }

    public function getParams($area = 0)
    {
        $settings = Registry::get('settings');
        $this->params = $settings->getNodeParams($this, $area);
        $this->params['node_type'] = $this->getType();
        $this->params['node_id'] = $this->id;
        return $this->params;
    }

    public function prepareDelete()
    {
        // области привязанные к этому разделу
        $areas = $this->getAreas();
        foreach ($areas as $area) {
            $area->delete();
        }
        // привязка этого раздела к другим разделам
        $nodeAreas = NodeArea::getListByKey('node_id', $this->id)->getItems();
        foreach ($nodeAreas as $area) {
            $area->delete();
        }
        if ($this->type->has_content) {
            $items = $this->getItems()->getItems();
            foreach ($items as $item) {
                $item->delete();
            }
        }
        $childs = static::getListBykey('parent', $this->id)->getItems();

        foreach ($childs as $node) {
            $node->delete();
        }
    }

    public function getFields()
    {
        return $this->type->getFields();
    }

    public function getCatalogFields()
    {
        return $this->type->getCatalogFields();
    }

    public function getVariantFields()
    {
        return $this->type->getVariantFields();
    }

    public function getAreas()
    {
        if (!empty($this->areas)) {
            return $this->areas;
        }
        $this->areas = NodeArea::getListByKey('node', $this->id)->getItems();
        return $this->areas;
    }

    public function getAssignArea($area_id)
    {
        $areas = $this->getAreas();
        foreach ($areas as $area) {
            if ($area->area == $area_id) {
                return $area;
            }
        }
        return null;
    }

    public function getItems($parameters = [], $limiter = null)
    {
        if (!empty($this->type->has_content)) {
            if ($this->type->is_catalog) {
                CatalogItem::$itemsTable = $this->getTable();
                $parameters['filters'][] = 'node = ' . $this->id;
                return CatalogItem::getList($parameters, $limiter);
            } else {
                Item::$itemsTable = $this->getTable();
                $parameters['filters'][] = 'node = ' . $this->id;
                return Item::getList($parameters, $limiter);
            }
        } else {
            return new RecordSet();
        }
    }

    public function getTemplate()
    {
        return $this->content_template->file;
    }

    public function getContentItem($id)
    {
        return new Item($this->getTable(), (int)$id);
    }

    public static function getStructure()
    {
        $cache_id = sprintf('%s_structure', static::getVar('table'));
        $structure = [];
        if (static::getVar('isCachable')) {
            $cm = CacheManager::getInstance();
            $structure = $cm->getCache($cache_id);
        }
        if (empty($structure)) {
            $structure = static::getListArray(['sorters' => ['parent ASC', 'weight ASC']])->getItems();
            if (static::getVar('isCachable')) {
                $cm->setCache($cache_id, $structure, static::getVar('cacheTime'));
            }
        }

        return $structure;
    }

    public static function simpleSave($id, $field, $value)
    {
        $db = Registry::get('db');
        $update = $db->sql->update();
        $update->table(static::getVar('table'));
        $update->set([$field => $value]);
        $update->where('id=' . $id);
        $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        //$db->update(static::getVar('table'),array($field => $value),'id='.$id);
        if (static::getVar('isCachable')) {
            $cm = CacheManager::getInstance();
            $cm->removeCache(sprintf('%s_object_%s', static::getVar('table'), $id));
            $cm->removeCache(sprintf('%s_objects', static::getVar('table')));
            $cm->removeCache(sprintf('%s_structure', static::getVar('table')));
        }
    }

    protected function updateCache()
    {
        if ($this->isCachable) {
            $cm = CacheManager::getInstance();
            $cm->removeCache(sprintf('%s_object_%s', static::getVar('table'), $this->id));
            $cm->removeCache(sprintf('%s_objects', static::getVar('table')));
            $cm->removeCache(sprintf('%s_structure', static::getVar('table')));
        }
    }

    protected function getImageParent($node)
    {
        if ($node->parent != 0 && !empty($node->parent)) {
            $parent = new Node($node->parent);
            if (!empty($parent->image->id)) {
                return $parent->image;
            } else {
                if (empty($parent->image->id) && !empty($parent->parent) && $parent->parent != 0) {
                    return $this->getImageParent($parent);
                }
            }
        }
    }

    private function getImages($array, $params)
    {
        foreach ($array as $value) {
            if (!empty($params[$value]) && !is_object($params[$value])) {
                $params[$value] = new Image($params[$value]);
            }
        }

        return $params;
    }

    private function getFiles($array, $params)
    {
        foreach ($array as $value) {
            if (!empty($params[$value]) && !is_object($params[$value])) {
                $params[$value] = new File($params[$value]);
            }
        }

        return $params;
    }

    public function getFilters($categories)
    {
        $filter = [];

        $nodes = sprintf(
            "properties->>'$.nodes' REGEXP '(^%d\,)|(\,%d\,)|(^%d$)|(\,%d$)'",
            $this->id,
            $this->id,
            $this->id,
            $this->id
        );

        // Назначенные в раздел сборные страницы
        if (!empty($this->params["selections"])) {
            $selectionNodes = explode(",", $this->params["selections"]);

            foreach ($selectionNodes as $key => $selectionNodeId) {
                $filters[] = sprintf(
                    "properties->>'$.category_advance' REGEXP '(^%d\,)|(\,%d\,)|(^%d$)|(\,%d$)'",
                    $selectionNodeId,
                    $selectionNodeId,
                    $selectionNodeId,
                    $selectionNodeId,
                );
            }

            if (!empty($filters)) {
                $selectionNodesFilter = implode("OR ", $filters);
            }
        }

        if ($this->selection) {
            $filter['id'] = sprintf(
                "properties->>'$.category_advance' REGEXP '(^%d\,)|(\,%d\,)|(^%d$)|(\,%d$)'",
                $this->id,
                $this->id,
                $this->id,
                $this->id,
            );
        } else {
            if (!empty($categories)) {
                $cats = array_column(Structure::get_instance()->get_flat_tree($this->id), 'id');
                array_unshift($cats, $this->id);
                if (!empty($selectionNodesFilter)) {
                    $filter['node'] = sprintf(
                        '(node IN (%s) OR %s OR %s)',
                        implode(',', $cats),
                        $nodes,
                        $selectionNodesFilter
                    );
                } else {
                    $filter['node'] = sprintf('(node IN (%s) OR %s)', implode(',', $cats), $nodes);
                }
            } else {
                if (!empty($selectionNodesFilter)) {
                    $filter['node'] = sprintf(
                        '(node = %s OR %s OR %s)',
                        $this->id,
                        $nodes,
                        $selectionNodesFilter
                    );
                } else {
                    $filter['node'] = sprintf('(node = %s OR %s)', $this->id, $nodes);
                }
            }
        }

        return $filter;
    }

    public function getCategories(): array
    {
        $parentType = $this->getType();

        // top-level sections for the root and all subsections for others
        $tree = $this->id === 4226 ?
            Structure::get_instance()->get_tree($this->id) :
            Structure::get_instance()->get_flat_tree($this->id);
        $cats = [];

        foreach ($tree as $key => $node) {
            if (!$node['public'] || $node['type'] != $parentType) {
                unset($tree[$key]);
                continue;
            }

            $node = new Node($node['id'], $node);
            $cats[$node->id] = [
                "title" => $node->h1 ?: $node->title,
                "url" => $node->getUrl(),
            ];
        }

        return $cats;
    }
}