<?php

class Site_Controller_Merchant extends Site_Controller{

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^(merchant)|(merchant\/.*)$/',
			$pathStr
		);
	}

	public function run(){
		$path = $this->removePathPrefix(join('/', $this->path));
		$path = explode('/', $path);
		if (!in_array($path[1], $this->getAvailableMerchantInterfaces())) {
			die('Unavailable merchant interface');
		}
		$method = sprintf('process%sRequest', ucfirst($path[1]));
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			die('Unavailable merchant method');
		}
		die();
	}

	private function getAvailableMerchantInterfaces(){
		$merchants = array();
		foreach (Params::$params['merchant'] as $key => $item) {
			$merchants[] = $key;
		}
		return $merchants;
	}

	private function checkSSL(){
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			return;
		}
		$this->trace('checkSSL failed');
		die();
	}


	private function processRobokassaRequest(){
		try {
			if (empty(Query::$post['InvId']) || empty(Query::$post['OutSum']) || empty(Query::$post['SignatureValue'])){
				throw new exception('Bad request');
			}
			$hash  = strtoupper(md5(join(":",array(
				Query::$post['OutSum'],
				Query::$post['InvId'],
				Params::$params['merchant']['robokassa']['pass_2']
			))));
			if ($hash != Query::$post['SignatureValue']){
				throw new exception('Bad hash');
			}
			$item = new Item_Order(Query::$post['InvId']);
			if (empty($item->id)){
				throw new exception('Order not found');
			}
			if ($item->summ != Query::$post['OutSum']){
				throw new exception('Wrong summ');
			}
			$item->status = new Item_Order_Status(3);
			$item->save();
			$item->user->updateSale();
			$item->notify('pay');
			echo 'OK'.$item->id; die;
		} catch (exception $e){
			die('ERROR-'.$e->getMessage());
		}
	}


	private function trace($subj){
		ob_start();
		echo "SERVER:\n";
		print_r($_SERVER);
		echo "POST:\n";
		print_r($_POST);
		echo "GET:\n";
		print_r($_GET);
		echo "REQUEST:\n";
		print_r($_REQUEST);
		$res = ob_get_clean();
		$headers = 'From: merchant@topform.ru';
		mail('alexey@topform.ru', $subj, $res, $headers);
	}
}