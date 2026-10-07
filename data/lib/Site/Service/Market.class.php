<?php

use App\Item;

class Site_Service_Market{

	public static $type = 'catalog';
	private $params = array();

	public function __construct() {
		$settings = Registry::get('settings');
		$this->params = $settings->getSiteParams();
		$this->params['site_url'] = 'http://' .$_SERVER['HTTP_HOST'];
	}

	public function display(){
		$categories = $this->getCategories();
		$items = $this->getItems($categories);
		$template = new Template();
		header('Content-type: text/xml; charset=utf-8');
		$template->assign('categories', $categories);
		$template->assign('items', $items);
		$template->assign('params', $this->params);
		$template->display('filters/yml.tpl');
		die;
	}

	private function getCategories(){
		$tree = Structure::get_instance()->get_tree();
		$cat_list = $this->getSubCategories($tree);
		$cats = array();
		foreach ($cat_list as $cat){
			$cats[$cat->id] = $cat;
		}
		foreach ($cats as $id => $cat){
			if (!array_key_exists($cat->parent,$cats)){
				$cats[$id]->parent = 0;
			}
		}
		return $cats;
	}

	private function getSubCategories($tree){
		$cats = array();
		foreach ($tree as $node){
			if ($node['type'] == self::$type && !empty($node['public'])){
				$cats[$node['id']] = new Node($node['id'],$node);
			}
			if (!empty($node['childs'])){
				$cats = array_merge($cats,$this->getSubCategories($node['childs']));
			}
		}
		return $cats;
	}

	private function getItems($categories){
		if (empty($categories)){
			return array();
		}
		$params = array(
			'filters' => array('public = 1', sprintf('node IN (%s)',join(',',array_keys($categories)))),
			'sorters' => array('sorter ASC', 'title ASC'),
		);
		$list = Item::get_list(false,'content_'.self::$type,$params)->getItems();
		$items = array();
		foreach($list as $item){
			$items[] = $this->prepareItem(new Item($item['id'],self::$type,$item),$categories[$item['node']]);
		}
		return $items;
	}

	private function prepareItem($item,$node){
		foreach ($item->fields as $field => $value){
			$item->$field = $value;
		}
		if (!empty($item->image)){
			$item->image= new Image($item->fields['image']);
			$item->image_url = $this->params['site_url'].$item->image->getLink();
		}
		$item->url = $this->params['site_url'].$node->getUrl().'?id='.$item->id;
		if ($item->newprice > 0){
			$item->oldprice = $item->price;
			$item->price = $item->newprice;
		}
		return $item;
	}

}
?>
