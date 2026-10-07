<?php

class Control_Filter_Tree extends Control_Filter {
	
	protected $defaultFilter = 'all';
	protected $tpl = 'filter_tree.tpl';
	protected $dbField = '';
	protected $getField = '';
	protected $list = array();

	const TYPE_ALL = 'all';

	public function __construct($field, $title = 'Элементы' ,$items = array(), $key = 'title',$space = '&nbsp;') {
		$this->setField($field);
		$this->title = $title;
		$this->setItems($items,$key,$space);
	}

	protected function setItems($list,$key,$space = '&nbsp;'){
		foreach ($list as $item){
			if (!is_array($item)){
				$item_a = $item->toArray();
			} else {
				$item_a = $item;
			}
			$this->list[$item_a['id']] = array('title' => $item_a[$key], 'value' => $item_a['id'], 'space' => $space, 'childs' => $this->getItemChilds($item));
			if (!empty($item['childs'])){
				$this->setItems($item['childs'],$key,$space.$space);
			}
		}
	}

	protected function getItemChilds($item){
		$childs = array();
		if (!empty($item['childs'])){
			foreach ($item['childs'] as $child){
				$childs[] = $child['id'];
				$childs = array_merge($childs,$this->getItemChilds($child));
			}
		}
		return $childs;
	}

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		if ($active == self::TYPE_ALL) {
			return '';
		}
		if (!empty($this->list[$active])){
			$item = $this->list[$active];
			$ids = $item['childs'];
			$ids[] = $item['value'];
			return sprintf("%s IN (%s)", $this->dbField, join(',',$ids));
		}
		return '';
		
	}

	public function getParams() {
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return array();
		}
		return array($this->getField => $active);
	}

}