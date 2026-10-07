<?php
class Site_Service_Cron_Mailer extends Site_Service_Cron {

	public $max_sended = 20;
	public $count_sended = 0;
	public $table = 'subscribe_sended';
	protected $tmpfiles = array();

	public function run(){
		// получение списка текущих рассылок (public - запущена, finished - еще не закончена)
		$subscribes = Item_Subscribe::getList(
			array(
				'filters' => array('finished=0','public=1'),
				'sorters' => array('date DESC'),
			)
		)->getItems();

		foreach ($subscribes as $subscribe){
			// пока количество отправленных писем не првзошло максимальное для одного раза
			if ($this->count_sended < $this->max_sended){
				$this->prepareSubscribe($subscribe);
			}
		}
		foreach ($this->tmpfiles as $file){
			unlink($file);
		}
	}

	protected function prepareSubscribe($subscribe){
		// список email с уже отосланными писбмами по этой рассылке
		$sended = $this->getSendedList($subscribe->id);
		// полный список email адресов по этой рассылке
		$total = $this->getToSendList($subscribe);

		$subscribe = new Item_Subscribe($subscribe->id);
		$subscribe->total = count($total);
		$subscribe->save();
		$db = Registry::get('db');

		$to_send = array_diff($total,$sended);
		if (!empty($to_send)){
			foreach ($to_send as $email){
				if ($this->count_sended < $this->max_sended){
					$this->count_sended++;
					$user = Item_Subscriber::getByEmail($email);
					if(!empty($user->id)){
						$mail = $this->createLetter($subscribe,$user);
					} else {
						$user = Cabinet_User::getByEmail($email);
						if(!empty($user->id)){
							$mail = $this->createLetter($subscribe,$user);
						} else {
							$mail = $this->createLetter($subscribe);
						}
					}
					$mail->addAddress($email,$email);
					$db->insert($this->table,array('subscribe' => $subscribe->id, 'email' => $email, 'date' => time()));
					$subscribe->sended++;
				}
			}
			if (@$mail->Send()){}
			$subscribe->save();
		} else {
			$subscribe->sended = count($total);
			$subscribe->finished = 1;
			$subscribe->save();
		}
	}

	protected function getSendedList($id){
		$searcher = new Searcher();
		$searcher->setTable($this->table);
		$searcher->noPager();
		$searcher->applySearchParameters(array(
			'sorters' => array('email ASC'),
			'filters' => array('subscribe = '.$id),
		));
		$recordSet = $searcher->search();
		$sended = array();
		foreach ($recordSet->getItems() as $item){
			$sended[] = $item['email'];
		}
		return $sended;
	}

	protected function getToSendList($subscribe){
		$emails = array();
		if (!empty($subscribe->themes)){
			$s_themes = $subscribe->themes;
			$subscribers = Item_Subscriber::getByTheme($subscribe->themes);
			foreach ($subscribers as $subscriber){
				$emails[] = $subscriber->email;
			}
			if(!empty($subscribe->addresses)){
				$addresses = explode(',',$subscribe->addresses);
				foreach($addresses as $address){
					if(preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/is',$address)){
						$emails[] = $address;
					}
				}
			}
			$db = Registry::get('db');
			$users = $db->query('SELECT subscribe,themes,email FROM user', $db::QUERY_MODE_EXECUTE)->toArray();
			foreach ($users as $user){
				if (!empty($user['email']) && preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/is',$user['email']) && !empty($user['subscribe'])){
					if(!empty($user['themes'])){
						$u_themes = explode(',',$user['themes']);
						$common_themes = array_intersect($s_themes,$u_themes);
						if (!empty($common_themes)){
							$emails[] = $user['email'];
						}
					} else {
						$emails[] = $user['email'];
					}
				}
			}
		} else {
			$subscribers = Item_Subscriber::getByKey('active',1);
			if(!empty($subscribers)){
				foreach ($subscribers as $subscriber){
					$emails[] = $subscriber->email;
				}
			}
			if(!empty($subscribe->addresses)){
				$addresses = explode(',',$subscribe->addresses);
				foreach($addresses as $address){
					if(preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/is',$address)){
						$emails[] = $address;
					}
				}
			}
			$db = Registry::get('db');
			$users = $db->query('SELECT subscribe,email FROM user WHERE subscribe=1 && active=1', $db::QUERY_MODE_EXECUTE)->toArray();
			foreach ($users as $user){
				$emails[] = $user['email'];
			}
		}
		return array_unique($emails);
	}

	protected function createLetter($subscribe,$user){

		$root_dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		// /common/data/lib/cron/

		$mail = new PHPMailer();

		$settings = Registry::get('settings');
		$site =  $settings->getSiteParams('sitename');
		$mail->From = $settings->getSiteParams('email');
		$mail->FromName = iconv('UTF-8','WINDOWS-1251',$site);
		$mail->Subject = iconv('UTF-8','WINDOWS-1251',$subscribe->title);
		$mail->CharSet  = 'Windows-1251';
		$mail->SingleTo	= true;

		if (!empty($subscribe->files)){
			$files = $subscribe->files;
			foreach ($files as $file){
				$file = new File($file);
				if (!empty($file->id)){
					$tmpfile = Params::$params['cache_path'].'tmp/'.uniqid(time()).'.tmp';
					file_put_contents($tmpfile,$file->getContent());
					$mail->AddAttachment(
						$tmpfile,
						$mail->EncodeHeader($file->src_name)
					);
					$this->tmpfiles[] = $tmpfile;
				}
			}
		}
		$content = $this->getTextLetter($subscribe,$user);
		$content = iconv('UTF-8','WINDOWS-1251',$content);
		if (preg_match_all('/src=(\"|\')([^\"\']+)/i', $content, $matches)){
			if (!empty($matches[2])){
				$images = array_unique($matches[2]);
				$i = 0;
				foreach($images as $image){
					if (!preg_match('/^http.*/i',$image)){
						$image_file = $root_dir.str_replace('common','common/htdocs',str_replace('common/htdocs', 'common', $image));
						if ($mail->AddEmbeddedImage($image_file,'embed_image_'.++$i)){
							$content = str_replace($image,'cid:embed_image_'.$i,$content);
						}
					}
				}
			}
		}
		$mail->MsgHTML($content);
		return $mail;
	}

	protected function getTextLetter($subscribe,$user = array()){
		$content = $subscribe->text;
		$hash = md5($user->email.'fgdgn');
		$content .= sprintf('<p><small>Чтобы отписаться от рассылки пройдите по <a href="%s/subscribe/unsubscribe?email=%s&hash=%s">ссылке</a></small></p>',Params::$params['public']['site']['host'], $user->email, $hash);
		$letterRecipes = array();
		if(!empty($subscribe->themes)){
			if(!empty($user->themes)){
				foreach($user->themes as $theme){

				}
			} elseif(!empty($subscribe->themes)) {
				foreach($subscribe->themes as $theme){

				}
			}
		}
		return $content;
	}
}

?>
