<?php

use App\Item;

class Site_Service_Api_Request extends Site_Service_Api {

	public $table = 'content_request';
	public $key = 'abc123def456';

	public $response = array(
		'status' => 'error',
		'message' => '',
		'data' => array()
		);

	public function run(){
		if ($this->checkRequest()){
			$list = Item::get_list(false,'content_request',array('filters' => array('get=0')))->getItems();
			$ids = array();
			foreach ($list as $item){
				$ids[] = $item['id'];
			}
			if(!empty($ids)){
				$db = Registry::get('db');
				$db->update('content_request',array('get' => 1),sprintf('id IN (%s)',join(',',$ids)));
			}
			$this->response['status'] = 'success';
			$this->response['data'] = $list;
		}
		echo json_encode($this->response); die;
	}

	public function checkRequest(){
		$request = Query::$get;
		if (!isset($request['hash'])){
			$this->response['status'] = 'error';
			$this->response['message'] = 'Bad hash';
			return false;
		}
		$hash = $request['hash'];
		unset($request['hash']);
		ksort($request);
		$data = array();;
		foreach ($request as $key => $val){
			$data[] = sprintf('%s=%s',$key,$val);
		}
		$data[] = $this->key;
		$str = strtolower(join(';',$data));
		if (md5($str) != $hash){
			$this->response['status'] = 'error';
			$this->response['message'] = 'Bad hash';
			return false;
		}
		return true;
	}
}
?>
