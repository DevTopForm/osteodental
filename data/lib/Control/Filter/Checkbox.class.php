<?php

class Control_Filter_Checkbox extends Control_Filter_Text{

	protected $tpl = 'filter_checkbox.tpl';

	public function setField($field){
		if (!empty($field)){
			$this->dbField = $field;
			$this->getField = sprintf('fcb_%s',$field);
		}
	}

	public function getActiveFilter(){
		if (empty(Query::$get[$this->getField])) {
			return 0;
		}
		return 1;
	}

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return '';
		}
		return sprintf("%s = '%d'",$this->dbField,$active);
	}
}