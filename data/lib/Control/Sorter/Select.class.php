<?php

class Control_Sorter_Select extends Control_Sorter_Abstract{

	public function getHTML(){
		$parsed = array();
		foreach ($this->fields as $type) {
			$parsed[$type] = $this->parseSorter($type);
		}
		return join('',$parsed);
	}

	protected function parseSorter($type){
		//todo: mb some refactoirng
		$isActive = ($this->getActiveSorter() == $type) ? true : false;
		if (!$isActive) {
			return sprintf('
			<div class="arrows">
				<div class="up"><a href="?sorter=%s&amp;order=%s"></a></div>
				<div class="down"><a href="?sorter=%s&amp;order=d%s"></a></div>
			</div>
			', $type, $this->getBindedParamsQueryString(), $type, $this->getBindedParamsQueryString());
		}
		if ('' == $this->getOrder()) {
			return sprintf('
				<div class="arrows">
					<div class="up"><span></span></div>
					<div class="down"><a href="?sorter=%s&amp;order=d%s"></a></div>
				</div>
				', $type, $this->getBindedParamsQueryString()
			);
		}
		return sprintf('
			<div class="arrows">
				<div class="up"><a href="?sorter=%s&amp;order=%s"></a></div>
				<div class="down"><span></span></div>
			</div>
			', $type, $this->getBindedParamsQueryString()
		);
	}
}
