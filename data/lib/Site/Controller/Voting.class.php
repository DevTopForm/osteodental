<?php

class Site_Controller_Voting extends Site_Controller_Abstract{

	protected $model = 'Site_Voting';

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^vote\/.*$/',
			$pathStr
		);
	}

	public function run(){
		$model = $this->model;
		$status = 'error';
		if(!empty(Query::$get['item']) && !empty(Query::$get['answer'])){
			switch($this->path[1]){
				case 'add':
					$item = new Node_Item('content_voting',(int) Query::$get['item']);
					$answer = Query::$get['answer'];
					if (!empty($item->id)){
						$item = $this->prepareItem($item,$answer);
						$model::getInstance()->addItem($item);
						$status = 'success';
					}
					break;
				case 'remove':
					$item = new Node_Item('content_voting',(int) Query::$get['item']);
					if (!empty($item->id)){
						$cookie = $model::getInstance();
						$cookie->removeItem($item);
						$status = 'success';
					}
					break;
			}
		}
		if($status=='success'){
			$tpl = new Template();
			$tpl->assign('item', $this->getVoting($item));
		}
		if (!empty(Query::$get['ajax'])){
			$result = array(	'status' => $status,
												'data' => $tpl->fetch('module/voting/inner.tpl')
											);
			echo json_encode($result);
			die;
		} else {
			Utils::redirectPrevious();
		}
	}

	protected function getVoting($item){
		$item = new Node_Item('content_voting', $item->id);
		foreach ($item->answers as $key => $answer){
			$item->answers[$key]['total'] = 0;
		}
		$results = Item_Result::getList(
			array(
				'filters'=> array(
					'item='.$item->id
				)
			)
		)->getItems();
		$item->total = 0;
		foreach ($results as $key => $result){
			$expl_variant = explode(';',$result->variant);
			if (count($expl_variant) == 1) {
				if (array_key_exists($expl_variant[0],$item->answers)){
					$item->answers[$expl_variant[0]]['total']++;
					$item->total++;
				} else {
					unset($results[$key]);
				}
			} elseif (count($expl_variant) > 1) {
				foreach ($expl_variant as $keyEXPL => $valueEXPL) {
					if (array_key_exists($valueEXPL,$item->answers)){
						$item->answers[$valueEXPL]['total']++;
						$item->total++;
					}
				}
			}
		}
		$item->results = $results;
		foreach ($item->answers as $key => $answer){
			$item->answers[$key]['percent'] = round(empty($item->total) ? 0 : $answer['total']/$item->total * 100,1);
		}
		$item->voted = Item_Result::isVoted($item);
		return $item;
	}

	protected function prepareItem($item,$answer){
		if(empty($item->node->id)){
			$item->node = new Node($item->node);
		}
		if(isset($item->miltiple)){
			$item->type = 'multiple';
		} else {
			$item->type = 'single';
		}
		$item->answer = null;
		if(!empty($answer)){
			$item->answers = unserialize($item->answers);
			if(is_array($answer) || array_key_exists($answer, $item->answers))
				$item->answer = $answer;
		}
		return $item;
	}

}
