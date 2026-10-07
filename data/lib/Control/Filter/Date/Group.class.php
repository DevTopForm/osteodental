<?php

class Control_Filter_Date_Group extends Control_Filter_Date{

	protected $tpl = 'filters/filter_period.tpl';
	protected $fields = array();

	public function __construct($fields = array(), $title = 'Дата') {
		foreach ($fields as $field){
			$this->fields[$field] = new Filter_Date_Period($field,$title);
		}
		$this->setField('date');
		$this->title = $title;
		$this->enabled_types = static::getAvailableTypes();
	}

	
	public static function getAvailableTypes(){
		return array(
			static::TYPE_PERIOD => array('type' => static::TYPE_PERIOD, 'title' => ''),
			static::TYPE_ALL => array('type' => static::TYPE_ALL, 'title' => 'Любая')
		);
	}

	public function setField($field){
		if (!empty($field)){
			$this->dbField = $field;
			$this->getField	= sprintf('fdg_%s',$field);
			$this->getFieldStart= sprintf('fdg_%s_start',$field);
			$this->getFieldEnd	= sprintf('fdg_%s_end',$field);
		}
	}

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return '';
		}
		$filters = array();
		foreach ($this->fields as $field){
			$field->setDefault($active,$this->getPeriodInterval());
			$filter = $field->getFilterSQL();
			if (!empty($filter)){
				$filters[] = $filter;
			}
		}
		return empty($filters) ? '' : sprintf('(%s)',join(') OR (',$filters));
	}
}