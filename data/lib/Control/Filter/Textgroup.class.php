<?php

class Control_Filter_Textgroup extends Control_Filter{

	protected $defaultFilter = '';
	protected $tpl = 'filter_textgroup.tpl';
	protected $dbField = '';
	protected $getField = 'fg_text';
	protected $equal = true;

	public function __construct($fields, $title = 'Элементы', $equal = true) {
		$this->setField($fields);
		$this->title = $title;
		$this->equal = $equal;
	}

	public function setDefault($filter){
		$this->defaultFilter = $filter;
	}

	public function setField($fields){
		$this->dbField = $fields;
	}

	public function getActiveFilter(){
		if (empty(Query::$get[$this->getField])) {
			return $this->defaultFilter;
		}
		return Query::$get[$this->getField];
	}

	public function getHTML(){
		$tpl = new Template();
		$tpl->assign('binded', $this->bindedParams);
		$tpl->assign('filter_title', $this->title);
		$tpl->assign('filter_name', $this->getField);
		$tpl->assign('active', $this->getActiveFilter());
		return $tpl->fetch('filters/'.$this->tpl);
	}

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return '';
		}
		if ($this->equal){
			$db = Registry::get('db');
			foreach ($this->dbField as $field){
				$sql_words[] = "`".$field."` LIKE ".$db->getPlatform()->quoteValue(''.$active.'%');
			}
			return '('.join($sql_words,' OR ').')';
		} else {
			require_once 'Stemmer/stemmer_class.php';

			$q_words = explode(' ',$active);
			if (count($q_words) > 0) {
				$stemmer = new RussianStemmer();
				foreach($q_words as $word) {
					if (mb_strlen($word) > 2) {
						$this->words[] = $stemmer->stem($word);
					}

				}
				
			}
			if (empty($this->words)){
				return '';
			}
			$sql_words = array();
			$db = Registry::get('db');
			foreach ($this->words as $word){
				foreach ($this->dbField as $field){
					$sql_words[] = "`".$field."` LIKE ".$db->getPlatform()->quoteValue(''.$word.'%');
				}
			}
			return '('.join($sql_words,' OR ').')';
		}
	}

	public function getParams() {
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return array();
		}
		return array($this->getField => $active);
	}

}