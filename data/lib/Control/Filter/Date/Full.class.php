<?php

class Control_Filter_Date_Full extends Control_Filter_Date{
	
	public static function getAvailableTypes(){
		return array(
			static::TYPE_PERIOD    => array('type' => static::TYPE_PERIOD, 'title' => ''),
			static::TYPE_MONTH     => array('type' => static::TYPE_MONTH, 'title' => 'За месяц'),
			static::TYPE_WEEK      => array('type' => static::TYPE_WEEK, 'title' => 'За неделю'),
			static::TYPE_YESTERDAY => array('type' => static::TYPE_YESTERDAY, 'title' => 'За вчера'),
			static::TYPE_TODAY     => array('type' => static::TYPE_TODAY, 'title' => 'За сегодня'),
			static::TYPE_ALL       => array('type' => static::TYPE_ALL, 'title' => 'Все'),
		);
	}

}