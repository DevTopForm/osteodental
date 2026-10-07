<?php
class Site_Service_Cron_Notify extends Site_Service_Cron {

	public $max_sended = 20;
	public $count_sended = 0;
	protected $tmpfiles = array();

	public function run(){
		// получение списка мероприятий до которых осталось 3 дня
		$day = strtotime(date("Y-m-d",strtotime('+3 days')));
		$events = Item_Event::getList(
			array(
				'filters' => array('public=1', sprintf('`date` BETWEEN %s AND %s', $day, $day+86399)),
			)
		)->getItems();
		foreach ($events as $event){
			$this->prepareEvent($event,'notify_3');
		}

		// получение списка мероприятий до которых осталось 3 дня
		$day = strtotime(date("Y-m-d",strtotime('+1 day')));
		$events = Item_Event::getList(
			array(
				'filters' => array('public=1', sprintf('`date` BETWEEN %s AND %s', $day, $day+86399)),
			)
		)->getItems();
		foreach ($events as $event){
			$this->prepareEvent($event,'notify_1');
		}
	}

	protected function prepareEvent($event,$key){
		$orders = Item_Order::getList(array('filters' => array($key.'=0','event='.$event->id)))->getItems();
		if (empty($orders)) return;

		$mail = $this->createLetter($event);
		foreach ($orders as $order){
			if ($this->count_sended < $this->max_sended){
				$this->count_sended++;
				$mail->addAddress($order->user->email,iconv('UTF-8','WINDOWS-1251',$order->user->firstname.' '.$order->user->lastname));
				$order->$key = 1;
				$order->save();
			}
		}
		if (@$mail->Send()){}
	}

	protected function createLetter($event){
		require_once('PHPMailer/class.phpmailer.php');

		$root_dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		// /common/data/lib/cron/

		$mail = new PHPMailer();

		$settings = Registry::get('settings');
		$site =  $settings->getSiteParams('sitename');
		$subject = 'Напоминание о мероприятии';

		$mail->From = $settings->getSiteParams('email');
		$mail->FromName = iconv('UTF-8','WINDOWS-1251',$site);
		$mail->Subject = iconv('UTF-8','WINDOWS-1251',$subject);
		$mail->CharSet  = 'Windows-1251';
		$mail->SingleTo	= true;

		$template = '
			<html>
				<head><title>%s</title></head>
				<body>
					<h3>%s</h3>
					<p><strong>Название мероприятия</strong>: %s</p>
					<p><strong>Даты проведения</strong>: %s</p>
					<p><strong>Лектор</strong>: %s</p>
					<p><strong>Место проведения</strong>: %s</p>
					<p><strong>Адрес</strong>: %s</p>
					<p><a href="%s%s">Подробнее</a></p>
				</body>
			</html>
		';
		$lektors = array();
		foreach ($event->lektor as $lektor){
			$lektors[] = $lektor->title;
		}
		$event->place = new Item_Content($event->place,array(),'place');
		$content = sprintf($template, $subject, $subject,
			$event->title,
			date('d.m.Y',$event->date).(empty($event->date_end) ? '' : date(' - d.m.Y',$event->date_end)),
			join(', ',$lektors),
			$event->place->title,
			$event->place->address,
			Params::$params['public']['site']['url'],
			$event->url
		);
		$mail->MsgHTML(iconv('UTF-8','WINDOWS-1251',$content));
		return $mail;
	}
}
?>
