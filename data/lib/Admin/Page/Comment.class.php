<?php

class Admin_Page_Comment extends Admin_Page_LAVED{

	protected $localTpl = 'content/comment.tpl';
	protected $action = 'comment';

	protected function setItemFields(){
		$this->item->text = strip_tags(Query::$post['text']);
		$this->item->date = strtotime(Query::$post['date']);
	}
	
	protected function executeRequestProcessing(){
		parent::executeRequestProcessing();
		if ($this->state == self::STATE_LIST) {
			$this->updateList();
		}
	}

	protected function updateList(){
		if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Comment($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
		if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Comment($item_id);
					$comment->public = 1;
					$comment->save();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
	}

	protected function getItem(){
		return new Item_Comment($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Comment::getList($this->getParameters(),20);
	}

}