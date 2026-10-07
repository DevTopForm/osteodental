<?php

class Control_Filter_Radio extends Control_Filter_Item{
	
	protected $tpl = 'filter_radio.tpl';

	public function getHTML(){
		$tpl = new Template();
		$filters = $this->list;
		$tpl->assign('filters',$filters);
		$tpl->assign('binded',$this->getBindedParamsQueryString());
		$tpl->assign('active',$this->getActiveFilter());
		$tpl->assign('name', $this->getField);
		$tpl->assign('title', $this->title);
		return $tpl->fetch('filters/'.$this->tpl);
	}


}