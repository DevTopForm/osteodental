<?php

class Control_Filter_Date_Period extends Control_Filter_Date{

	protected $tpl = 'filters/filter_period.tpl';
	
	public static function getAvailableTypes(){
		return array(
			self::TYPE_PERIOD => array('type' => self::TYPE_PERIOD, 'title' => ''),
			self::TYPE_ALL => array('type' => self::TYPE_ALL, 'title' => 'Любая')
		);
	}

}