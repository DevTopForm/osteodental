<?php

class Control_Filter_Multiitem extends Control_Filter_Abstract implements Control_Filter{
	
	protected $defaultFilter = 'all';
	protected $tpl = 'filter_item.tpl';
	protected $dbField = '';
	protected $table = '';
	protected $separator = ',';
	protected $getField = '';
	protected $list = array();

	const TYPE_ALL = 'all';

	public function __construct($table,$field,$title='Элементы',$items=array(),$key='title',$separator=',') {
		$this->table = $table;
		$this->setField($field);
		$this->title = $title;
		$this->setItems($items,$key);
	}

	protected function setItems($list,$key){
		foreach ($list as $item){
			if (!is_array($item)){
				$item_a = $item->toArray();
			} else {
				$item_a = $item;
			}
			$this->list[$item_a['id']] = array('title' => $item_a[$key], 'value' => $item_a['id']);
		}
	}

	public function setDefault($filter){
		$this->defaultFilter = $filter;
	}

	public function setField($field){
		if (!empty($field)){
			$this->dbField = $field;
			$this->getField = sprintf('fmi_%s',$field);
		}
	}

	public function getActiveFilter(){
		if (!isset(Query::$get[$this->getField])) {
			return $this->defaultFilter;
		} elseif (is_array(Query::$get[$this->getField])) {

		} elseif (!in_array(Query::$get[$this->getField], array_keys($this->list))) {
			return self::TYPE_ALL;
		}
		return Query::$get[$this->getField];
	}

	public function getHTML(){
		$tpl = new Template();
		$filters = $this->list;
		array_unshift($filters, array('title' => "Все", 'value' => self::TYPE_ALL));
		$tpl->assign('filters',$filters);
		$tpl->assign('binded',$this->getBindedParamsQueryString());
		$tpl->assign('active',$this->getActiveFilter());
		$tpl->assign('name', $this->getField);
		$tpl->assign('title', $this->title);
		return $tpl->fetch('filters/'.$this->tpl);
	}

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		if ($active == self::TYPE_ALL) {
			return '';
		}
		$db = Registry::get('db');
		$list = $db->query(sprintf('SELECT `id`,`%s` FROM `%s` WHERE `public` = ?',$this->dbField,$this->table), [1])->toArray();
		$ids = array();
		foreach ($list as $item){
			if (empty($item[$this->dbField])) continue;
			$values = explode($this->separator,$item[$this->dbField]);
			if (array_search($active,$values) !== false){
				$ids[] = $item['id'];
			}
            /*$compareArray = array_intersect($active,$values);
            if (!empty($compareArray)){
                $ids = array_merge($ids, $compareArray);
            }*/
		}
		return empty($ids) ? 'FALSE' : sprintf("id IN (%s)", join(',',$ids));
	}

	public function getParams() {
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return array();
		}
		return array($this->getField => $active);
	}

}