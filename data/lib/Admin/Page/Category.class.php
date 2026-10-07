<?php

class Admin_Page_Category extends Admin_Page_LAVED {
    protected $localTpl = 'content/category.tpl';
    protected $action = 'list';

    protected function getStateRegexps(){
        return array(
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+\/\-?\d+$/i',
            self::STATE_ADD => '/^add\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+\/\d+$/i',
        );
    }

    protected function getItem(){
        $item = new Node_Item($this->node->getTable(),$this->extractItemId());
        return $item;
    }

    protected function getItemsList(){
        //return $this->node->getItems($this->getParameters(),25);
    }

    //новое обновление c laminas
    protected function updateDbCatalog($data, $table, $where){
        $db = Registry::get('db');
        $update = $db->sql->update();
        $update->table($table);
        $update->set($data);
        $update->where($where);
        $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
    }

    //выборка из бд
    protected function selectDbCatalog($table, $where){
        $db = Registry::get('db');
        $result = $db->query(sprintf('SELECT * FROM `%s` WHERE `public` = ?',$table), [1])->toArray();
    }

    protected function parseStateList(){
        $tpl = $this->getItemsTpl();
        if (!empty(Query::$post['listaction'])){

            if (empty(Query::$post['check_all'])) {
                if (empty(Query::$post['list'])){
                    Utils::redirectPrevious();
                }
            }

            $db = Registry::get('db');
            switch (Query::$post['listaction']){
                case "public":
                    if (!empty(Query::$post['check_all'])) {
                        $ids = Query::$post['check_all'];
                    } else {
                        $ids = implode(',',Query::$post['list']);
                    }
                    if (!empty($ids)){
                        $data = ['public' => 1];
                        $where = sprintf('id IN (%s)',$ids);
                        $this->updateDbCatalog($data, 'content_catalog', $where);
                    }
                    break;
                case "public_clear":
                    if (!empty(Query::$post['check_all'])) {
                        $ids = Query::$post['check_all'];
                    } else {
                        $ids = implode(',',Query::$post['list']);
                    }
                    if (!empty($ids)){
                        $data = ['public' => 0];
                        $where = sprintf('id IN (%s)',$ids);
                        $this->updateDbCatalog($data, 'content_catalog', $where);
                    }
                    break;
                case "text":
                    $productText = Query::$post['text'];
                    if (!empty(Query::$post['check_all'])) {
                        $ids = Query::$post['check_all'];
                    } else {
                        $ids = implode(',',Query::$post['list']);
                    }
                    if (!empty($ids)){
                        $data = ['text' => $productText];
                        $where = sprintf('id IN (%s)',$ids);
                        $this->updateDbCatalog($data, 'content_catalog', $where);
                    }
                    break;
                case "category":
                    $category = (int) Query::$post['category'];
                    if (!empty($category)){
                        if (!empty(Query::$post['check_all'])) {
                            $ids = Query::$post['check_all'];
                        } else {
                            $ids = implode(',',Query::$post['list']);
                        }
                        if (!empty($ids)){
                            $data = ['node' => $category];
                            $where = sprintf('id IN (%s)',$ids);
                            $this->updateDbCatalog($data, 'content_catalog', $where);
                        }
                    }
                    break;
                default:
                    break;
            }
            Utils::redirectPrevious();
        }

        $filterParams = $this->getParameters();
        if(!empty(Query::$get['catalog_filter'])){
            $arID = [];
            unset($filterParams['filters']['variant']);
            $preResult = Item_Catalog::getList($filterParams)->getItems();
            if(!empty($preResult)){
                foreach($preResult as $itemResult){
                    $arID[] = $itemResult->id;
                }
                $filterParams['filters'] = ["id IN(".implode(',', $arID).")"];
            }else{
                $filterParams['filters'] = ["id = 0"];
            }

            $nodes = Node::getListArray($filterParams)->getItems();//получаем список разделов
        } else {
            $nodes = Node::getListArray(['filters' => ['public=1']])->getItems();//получаем список разделов
        }

        $tpl->assign('list',$nodes);
        $tpl->assign('data',$this->getSpecialListData());
        $tpl->assign('filters',$this->getFiltersHtml());
        return $tpl->fetch($this->localTpl);
    }

    protected function getCategories($parentId = 4102){
        $parentType = $this->node->getType();
        $tree = Structure::get_instance()->get_tree($parentId);
        $cats = array();

        foreach($tree as $key => $node)	{
            if (!$node['public'] || $node['type'] != $parentType) {
                unset($tree[$key]);
                continue;
            }

            $node = new Node($node['id'],$node);
            $node->url = $node->getUrl();
            $cats[$node->id] = $node;
        }

        return $cats;
    }

    protected function getSpecialListData(){
        $data = [];
        $tree = new Control_Filter_Node('node','Категория');
        $data['tree'] = $tree->tree;
        Node_Item::$itemsTable = 'content_brands';
        $data['brands'] = Node_Item::getList(['sorters' => ['title ASC']])->getItems();
        Node_Item::$itemsTable = 'content_stocks';
        $data['stock'] = Node_Item::getList(['filters' => ['public=1'], 'sorters' => ['title ASC']])->getItems();
        Node_Item::$itemsTable = 'content_promo';
        $data['promo'] = Node_Item::getList(['filters' => ['public=1'], 'sorters' => ['title ASC']])->getItems();
        return $data;
    }

    protected function getParameters(){
        $parameters = array(
            'filters' => $this->getListFilters(),
            'sorters' => $this->getListSorters()
        );
        $this->countFilters = array();
        foreach ($parameters['filters'] as $key => $filter){
            if ($filter instanceOf Control_Element){
                $this->countFilters[$key] = $filter->getFilterSQL();
            } else {
                $this->countFilters[$key] = $filter;
            }
        }
        $this->filters = $this->prepareFilters($parameters);
        return $parameters;
    }

    protected function getListSorters(){
        return array('title ASC');
    }

    protected function getListFilters(){
        $filters = array(
            'node' => new Control_Filter_Node('node','Категория'),
            'title' => new Control_Filter_Text('title','Название'),
        );
        return $filters;
    }

    protected function getFiltersHtml(){
        $filters = array();
        foreach ($this->filters as $key => $filter){
            if ($filter instanceOf Control_Element){
                $filters[$key] = $filter->getHTML();
            } else {
                $filters[$key] = $filter;
            }
        }
        return $filters;
    }

    protected function prepareFilters($parameters = array()){
        $filters = array();
        foreach ($parameters as $group){
            foreach ($group as $key => $filter){
                $filters[$key] = $filter;
            }
        }
        foreach ($filters as $key => $filter){
            foreach ($filters as $bindFilter){
                if ($filter instanceOf Control_Element && $filter !== $bindFilter){
                    $filters[$key]->bindWith($bindFilter);
                }
            }
        }
        return $filters;
    }
}
