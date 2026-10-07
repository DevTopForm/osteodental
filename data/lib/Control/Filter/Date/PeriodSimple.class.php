<?php

class Control_Filter_Date_PeriodSimple extends Control_Filter_Date{

	protected $tpl = 'filters/filter_period.tpl';
	
	public static function getAvailableTypes(){
		return array(
			static::TYPE_PERIOD => array('type' => self::TYPE_PERIOD, 'title' => ''),
		);
	}

}