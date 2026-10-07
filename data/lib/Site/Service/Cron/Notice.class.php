<?php

use App\Item;

class Site_Service_Cron_Notice extends Site_Service_Cron {

	public $max_sended = 20;
	public $count_sended = 0;

	public function run(){
		$db = Registry::get('db');
		$notices = Item_Notice::getList()->getItems();
		if (empty($notices)){
			return;
		}
		$items = array();
		foreach ($notices as $notice){
			if (empty($items[$notice->item])){
				$items[$notice->item] = array();
			}
			$items[$notice->item][] = $notice;
		}
		if (empty($items)){
			return;
		}
		$available = Item::get_list(false,'content_catalog',array('filters' => array('notavailable = 0',sprintf('id IN (%s)',join(',',array_keys($items))))))->getItems();
		if (empty($available)){
			return;
		}
		$list = array();
		foreach ($available as $item){
			$item = self::prepareInList($item);
			if (!empty($items[$item->id])){
				$mail = $this->createLetter($item);
				foreach ($items[$item->id] as $notice){
					if ($this->count_sended < $this->max_sended){
						$this->count_sended++;
						$mail->addAddress($notice->email,$notice->email);
						$notice->delete();
					}
				}
				if ($mail->Send()){
				}
			}
		}
	}

	protected static function prepareInList($item,$params = null){
		if (!($item instanceof Item)){
			if (is_array($item)){
				$node = new Node($item['node']);
				$item = new Item($item['id'],$node->getType(),$item);
			} else {
				return null;
			}
		} else {
			$node = new Node($item->node);
		}
		if (is_null($params)){
			$params = $node->getParams();
		}
		$item->n_obj = $node;
		foreach ($item->fields as $field => $value){
			$item->$field = $value;
		}
		if (!empty($item->alias)){
			$item->url = $node->getUrl().'/'.$item->alias;
		} else {
			$item->url = $node->getUrl().'?id='.$item->id;
		}
		if (!empty($item->image)){
			$item->image= new Image($item->fields['image']);
		}
		return $item;
	}

	protected function createLetter($item){
		require_once('PHPMailer/class.phpmailer.php');

		$root_dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		// /common/data/lib/cron/

		$mail = new PHPMailer();

		$settings = Registry::get('settings');

		$subject  = "Уведомление о появлении товара на складе";

		$site =  $settings->getSiteParams('sitename');
		$email =  $settings->getSiteParams('email');
		$siteurl = Params::$params['public']['site']['url'];

		$mail->From = $email;
		$mail->FromName = iconv('UTF-8','WINDOWS-1251',$site);
		$mail->Subject = iconv('UTF-8','WINDOWS-1251',$subject);
		$mail->CharSet  = 'Windows-1251';
		$mail->SingleTo	= true;

		$template = '
			<html>
				<head><title>%s</title></head>
				<body>
					<h3>Здравствуйте!</h3>
					<p>Вы подписывались на информацию о товаре "%s", размещенном по адресу <a href="%s">%s</a>. Сообщаем Вам, что товар поступил на склад, пройдите по ссылке, чтобы совершить покупку.</p>
				</body>
			</html>
		';
		$content = iconv('UTF-8','WINDOWS-1251',sprintf($template,$subject,$item->title,$siteurl.$item->url,$siteurl.$item->url));
		$mail->MsgHTML($content);
		return $mail;
	}
}
?>
