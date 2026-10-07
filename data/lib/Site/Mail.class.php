<?php

class Site_Mail{
	
	public $subject = '';
	public $content = '';
	private $emails = array();
	
	public function __construct($subject,$content) {
		$this->subject = $subject;
		$this->content = $content;
	}

	public function addAddress($email,$name = ''){
		$this->emails[] = array($email,$name);
	}

	public function send(){
		$settings = Registry::get('settings');
		require_once('Utils/PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();

		$from =  $settings->getSiteParams('from_email');
		$site =  $settings->getSiteParams('sitename');

		$mail->From     = empty($from) ? ("noreply@".$_SERVER['SERVER_NAME']) : $from;
		$mail->FromName = iconv('UTF-8','WINDOWS-1251',$site);
		$mail->Subject  = iconv('UTF-8','WINDOWS-1251',$this->subject);
		$mail->CharSet  = 'Windows-1251';
		$mail->SingleTo	= true;
		$mail->ContentType = 'text/html';

		if (!empty($this->emails)){
			foreach ($this->emails as $email){
				$mail->AddAddress($email[0],empty($email[1]) ? iconv('UTF-8','WINDOWS-1251',$email[1]) : $email[0]);
			}
		} else {
			return;
		}
		$mail->MsgHTML(iconv('UTF-8','WINDOWS-1251',$this->content));
		if (!@$mail->Send()){
			//pre($mail); die;
		}
	}
}