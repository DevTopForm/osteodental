<?php

abstract class Control_Sorter_Abstract extends Control_Element implements Control_Sorter{

	const SORTER_GET_FIELD = 'sorter';
	const ORDER_GET_FIELD = 'order';

	protected $defaultSorter = '';
	protected $order = '';
	protected $defaultOrder = '';
	protected $fields = array();
	protected $titles = array();

	public function __construct($fields = array()){		
		if (!empty($fields)){			
			$this->fields = array();
			$this->titles = $fields;
			foreach($fields as $key => $field)
			$this->fields[] = $key;
		}
	}

	public function getActiveSorter(){
		if (empty(Query::$get[self::SORTER_GET_FIELD])) {
			return $this->defaultSorter;
		}
		if (!in_array(Query::$get[self::SORTER_GET_FIELD], $this->fields)) {
			return $this->defaultSorter;
		}
		return Query::$get[self::SORTER_GET_FIELD];
	}

	public function getHTML(){
		$parsed = array();		
		foreach ($this->fields as $type) {
			$parsed[$type] = $this->parseSorter($type);
		}		
		return join('',$parsed);
	}

	public function getSorterSQL(){
		$active = $this->getActiveSorter();
		if (empty($active)) {
			return '';
		}
		return $active . $this->getOrder();
	}

	public function getParams() {
		$active = $this->getActiveSorter();
		if (empty($active)) {
			return array();
		}
		$params = array(self::SORTER_GET_FIELD => $active);
		if ('' !== $this->getOrder()) {
			$params[self::ORDER_GET_FIELD] = 'd';
		}
		return $params;
	}

	protected function parseSorter($type){		
		//todo: mb some refactoirng
		$isActive = ($this->getActiveSorter() == $type) ? true : false;
		if (!$isActive) {			
			return sprintf('<a href="?sorter=%s&amp;order=%s" class="item">%s</a>', $type, $this->getBindedParamsQueryString(),$this->titles[$type]);
		}
		if ('' == $this->getOrder()) {
			return sprintf('<a href="?sorter=%s&amp;order=d%s" class="item active">%s</a>', $type, $this->getBindedParamsQueryString(),$this->titles[$type]);
		}
		return sprintf('<a href="?sorter=%s&amp;order=%s" class="item active">%s</a>', $type, $this->getBindedParamsQueryString(),$this->titles[$type]);
	}

	protected function getOrder(){
		if (empty(Query::$get[self::SORTER_GET_FIELD])) {
			return ('d' == $this->defaultOrder) ? ' DESC' : '';
		}
		if (!isset(Query::$get[self::ORDER_GET_FIELD])) {
			return '';
		}
		return ('d' == Query::$get[self::ORDER_GET_FIELD]) ?  ' DESC' : '';
	}

	public function setDefaultSorter($sorter = 'sorter',$order =''){
		$this->defaultSorter = $sorter;
		$this->defaultOrder = $order;
	}

	public function addField($field){		
		if (!in_array($field,$this->fields)){
			$this->fields[] = $field;
		}
	}
}
