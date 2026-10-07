<?php

class Admin_Page_Status extends Admin_Page_LAVED{

	protected $localTpl = 'content/status.tpl';
	protected $action = 'status';

	protected function executeRequestProcessing(){
		parent::executeRequestProcessing();
		if ($this->state == self::STATE_LIST) {
			$this->updateList();
		}
	}

	protected function setItemFields(){
		$this->item->title = strip_tags(Query::$post['title']);
	}

	protected function updateList(){
		if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Status($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
		if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Status($item_id);
					$comment->public = 1;
					$comment->save();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
	}

	protected function getListSorters(){
		return array('sorter' => 'ID DESC');
	}

	protected function getItem(){
		return new Item_Order_Status($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Order_Status::getList($this->getParameters(),20);
	}
}
