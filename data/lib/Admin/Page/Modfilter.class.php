<?php

class Admin_Page_Modfilter extends Admin_Page_ModLAVED{

	protected $localTpl = 'content/modfilter.tpl';

	protected function executeRequestProcessing(){
		$module = new Node_Type(@intval($this->parts[3]));
		if (empty($module->has_content)) Utils::redirect($this->admPath.'/module');		
		parent::executeRequestProcessing();
	}

	protected function setItemFields(){
		$this->item->type = $this->module->type;
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->filter = strip_tags(Query::$post['filter']);
		$this->item->field = strip_tags(Query::$post['field']);
		$this->item->multiple = empty(Query::$post['multiple']) ? 0 : 1;
	}

	protected function getItem(){
		return new Node_Filter($this->extractItemId());
	}

	protected function getItemsList(){
		return Node_Filter::getList($this->getParameters());
	}

	protected function getSpecialEditData(){
		return array(
			//'types' => Node_Fielditem::$types,
			);
	}

}