<?php

namespace App\Control\Filter;

use App\Control\Element;
use App\Control\Filter;
use App\Query;
use App\Registry;
use App\Template;

class Text extends Element implements Filter {

	protected $defaultFilter = '';
	protected $tpl = 'filter_text.tpl';
	protected $dbField = '';
	protected $getField = '';
	protected $equal = true;

	const GET_FIELD = 's';

	public function __construct($field, $title = 'Элементы', $equal = true) {
		$this->setField($field);
		$this->title = $title;
		$this->equal = $equal;
	}

	public function setDefault($filter){
		$this->defaultFilter = $filter;
	}

	public function setField($field){
		if (!empty($field)){
			$this->dbField = $field;
			$this->getField = sprintf('ft_%s',$field);
		}
	}

	public function getActiveFilter(){
		if(!empty(Query::$post[$this->getField])){
			return Query::$post[$this->getField];
		}

		if (empty(Query::$get[$this->getField])) {
			return $this->defaultFilter;
		}
		return Query::$get[$this->getField];
	}

	public function getHTML(){
		$tpl = new Template();
		$tpl->assign('binded', $this->bindedParams);
		$tpl->assign('bindedString', $this->getBindedParamsQueryString());		
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
			return "`".$this->dbField."` LIKE ".$db->getPlatform()->quoteValue('%'.$active.'%');
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
				$sql_words[] = "`".$this->dbField."` LIKE ".$db->getPlatform()->quoteValue(''.$word.'%');
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
