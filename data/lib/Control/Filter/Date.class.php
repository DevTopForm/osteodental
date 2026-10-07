<?php

class Control_Filter_Date extends Control_Filter_Abstract implements Control_Filter{
	
	protected $enabled_types = array();
	protected $dbField = '';
	protected $getField = '';
	protected $getFieldStart = '';
	protected $getFieldEnd = '';

	protected $tpl = 'filters/filter_date.tpl';
	
	protected $full_filter = false;
	
	const TYPE_PERIOD    = 'period';
	const TYPE_MONTH     = 'month';
	const TYPE_ALL       = 'all';
	const TYPE_TODAY     = 'today';
	const TYPE_YESTERDAY = 'yesterday';
	const TYPE_WEEK      = 'week';

	public function __construct($field, $title = 'Дата') {
		$this->setField($field);
		$this->title = $title;
		$this->enabled_types = self::getAvailableTypes();
	}

	public function setDefault($type,$params){
		switch ($type) {
			case self::TYPE_PERIOD:
				Query::$get[$this->getField] = $type;
				Query::$get[$this->getFieldStart] = date('Y-m-d',empty($params['start']) ? time() : $params['start']);
				Query::$get[$this->getFieldEnd] = date('Y-m-d',empty($params['end']) ? time() : $params['end']);
				break;
			case self::TYPE_MONTH:
			case self::TYPE_TODAY:
			case self::TYPE_YESTERDAY:
			case self::TYPE_WEEK:
			case self::TYPE_ALL:
				Query::$get[$this->getField] = $type;
				break;
			default:
				break;
		}
	}

	public function setField($field){
		if (!empty($field)){
			$this->dbField = $field;
			$this->getField	= sprintf('fd_%s',$field);
			$this->getFieldStart= sprintf('fd_%s_start',$field);
			$this->getFieldEnd	= sprintf('fd_%s_end',$field);
		}
	}

	public static function getAvailableTypes(){
		return array(
			self::TYPE_PERIOD    => array('type' => self::TYPE_PERIOD, 'title' => ''),
			self::TYPE_ALL       => array('type' => self::TYPE_ALL, 'title' => 'Все'),
		);
	}

	public function setTypes($types = array()){
		if (!is_array($types)) {
			echo sprintf('%s %s %s: Array expected', __FILE__, __METHOD__, __LINE__);
			return;
		}
		$availableTypes = array_keys(self::getAvailableTypes());
		foreach ($types as $key => $type) {
			if (!in_array($type, $availableTypes)) {
				unset($types[$key]);
			}
		}
		if (empty($types)) {
			return;
		}
		$this->enabled_types = $types;
	}

	public function setDbField($field){
		$this->dbField = $field;
	}

	public function getActiveFilter(){
		if (empty(Query::$get[$this->getField])) {
			if (array_key_exists(self::TYPE_ALL,$this->enabled_types)){
				return self::TYPE_ALL;
			} elseif (array_key_exists(self::TYPE_MONTH,$this->enabled_types)){
				return self::TYPE_MONTH;
			} else {
				return '';
			}
		}
		if (!array_key_exists(Query::$get[$this->getField], $this->enabled_types)) {
			return '';
		}
		return Query::$get[$this->getField];
	}

	public function getHTML(){
		$tpl = new Template();
		$types = array();
		foreach ($this->enabled_types as $key => $data) {
			if ($key == self::TYPE_PERIOD) continue;
			$types[] = array(
				'title' => $data['title'],
				'type' => $key,
				'active' => ($this->getActiveFilter() == $key) ? 1 : 0,
			);
		}
		$tpl->assign('title',$this->title);
		$tpl->assign('name',$this->getField);
		$tpl->assign('data', $types);
		$tpl->assign('binded', $this->getBindedParamsQueryString());
		if (array_key_exists(self::TYPE_PERIOD, $this->enabled_types)) {
			$interval = $this->getPeriodInterval();
			$period = array(
				'type' => self::TYPE_PERIOD,
				'active' => ($this->getActiveFilter() == self::TYPE_PERIOD) ? 1 : 0,
				'start' => array('name' => $this->getFieldStart,'value' => empty($interval['start']) ? '' : date('d-m-Y',$interval['start'])),
				'end' => array('name' => $this->getFieldEnd,'value' => empty($interval['end']) ? '' : date('d-m-Y',$interval['end'])),
				'binded' => $this->bindedParams,
			);
			$tpl->assign('period', $period);
		}
		return $tpl->fetch($this->tpl);
	}

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return '';
		}
		switch ($active) {
			case self::TYPE_PERIOD:
				$interval = $this->getPeriodInterval();
				if (!empty($interval['start']) && !empty($interval['end'])) {
					return sprintf("`%s` BETWEEN '%s' AND '%s'", $this->dbField, $interval['start'], $interval['end']);
				} elseif (!empty($interval['start'])) {
					return sprintf("`%s` >= '%s'", $this->dbField, $interval['start']);
				} elseif (!empty($interval['end'])) {
					return sprintf("`%s` <= '%s'", $this->dbField, $interval['end']);
				} else {
					return '';
				}
			case self::TYPE_MONTH:
				return sprintf('`%s` >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)', $this->dbField);
			case self::TYPE_TODAY:
				return sprintf('`%s` >= CURDATE()', $this->dbField);
			case self::TYPE_YESTERDAY:
				return sprintf('`%s` >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)', $this->dbField);
			case self::TYPE_WEEK:
				return sprintf('`%s` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)', $this->dbField);
			case self::TYPE_ALL:
			default:
				return '';
		}
	}


	public function getParams() {
		$active = $this->getActiveFilter();
		if (empty($active)) {
			return array();
		}
		$params = array($this->getField => $active);
		if ($active == self::TYPE_PERIOD) {
			$interval = $this->getPeriodInterval();
			$params[$this->getFieldStart] = empty($interval['start']) ? '' : date('Y-m-d',$interval['start']);
			$params[$this->getFieldEnd]   = empty($interval['end']) ? '' : date('Y-m-d',$interval['end']);
		}
		return $params;
	}

	protected function getPeriodInterval(){
		$start = empty(Query::$get[$this->getFieldStart]) ? '' : strtotime(Query::$get[$this->getFieldStart].' 00:00');
		$end = empty(Query::$get[$this->getFieldEnd]) ? '' : strtotime(Query::$get[$this->getFieldEnd].' 23:59');
		return array('start' => $start, 'end' => $end);
	}

}