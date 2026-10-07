<?php

class Admin_Page_Payway extends Admin_Page_LAVED{

	protected $localTpl = 'content/payway.tpl';
	protected $action = 'payway';

	protected function executeRequestProcessing(){
		parent::executeRequestProcessing();
		if ($this->state == self::STATE_LIST) {
			$this->updateList();
		}
	}

	protected function setItemFields(){
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->active = isset(Query::$post['active']) ? 1 : 0;
	}

	protected function updateList(){
		if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Payway($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
		if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Payway($item_id);
					$comment->active = 1;
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
		return new Item_Order_Payway($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Order_Payway::getList($this->getParameters(),20);
	}
}
