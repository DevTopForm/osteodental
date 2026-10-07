<?php

class Control_Filter_Perpage extends Control_Filter_Abstract{
	const PERPAGE_GET_FIELD = 'perpage';

	protected $defaultPerpage = '12';
	protected $fields = array();

	public function __construct($values = array()){
		if (!empty($values)){
			$this->values = $values;
		}
	}

	public function getActiveFilter(){
		if (empty(Query::$get[self::PERPAGE_GET_FIELD])) {
			return $this->defaultPerpage;
		}
		if (!in_array(Query::$get[self::PERPAGE_GET_FIELD], $this->values)) {
			return $this->defaultPerpage;
		}
		return Query::$get[self::PERPAGE_GET_FIELD];
	}

	public function getHTML(){
		$parsed = array();
		foreach ($this->values as $value) {
			$parsed[$value] = $this->parsePerpage($value);
		}
		return join('',$parsed);
	}

	public function getFilterSQL(){		
			return '';	
	}

	public function getParams() {
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return array();
		}
		return array(self::PERPAGE_GET_FIELD => $active);		 
	}

	protected function parsePerpage($value){		
			$isActive = ($this->getActiveFilter() == $value) ? 'active' : false;			
			return sprintf('<a  href="?perpage=%s%s" class="item %s">%s</a>',  $value, $this->getBindedParamsQueryString(),$isActive,$value);			
	}
	


	public function setDefaultFilter($filter = '12'){
		$this->defaultPerpage = $filter;		
	}	
}
