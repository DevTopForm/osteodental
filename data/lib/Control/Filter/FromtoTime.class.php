<?php

class Control_Filter_FromtoTime extends Control_Filter_Fromto{

	public function getFilterSQL(){
		$active = $this->getActiveFilter();
		$filters = array();
		$year = 365*24*60*60;
		if (!empty($active['from'])){
			$filters[] = sprintf('`%s` <= "%s"',$this->dbField,time()-$active['from']*$year);
		}
		if (!empty($active['to'])){
			$filters[] = sprintf('`%s` >= "%s"',$this->dbField,time()-$active['to']*$year);
		}
		return join(' AND ',$filters);
	}

}