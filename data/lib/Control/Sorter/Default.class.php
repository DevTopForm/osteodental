<?php

class Control_Sorter_Default extends Control_Sorter_Abstract{


	/*public function getSorterSQL(){
		$active = $this->getActiveSorter();
		if (empty($active)) {
			return '';
		}
		if($active=='price'){
			$active='IF (
			(SELECT min( varnt.price ) FROM `content_catalog` varnt WHERE varnt.variant = `content_catalog`.id),
			(SELECT min( varnt.price ) FROM `content_catalog` varnt WHERE varnt.variant = `content_catalog`.id),
			`content_catalog`.price)
			';
		}
		return $active . $this->getOrder();
	}*/
}
