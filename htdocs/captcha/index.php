<?php

ini_set('display_errors',0);
include('kcaptcha.php');

session_start();
$captcha_id = empty($_REQUEST['key']) ? 'default' : $_REQUEST['key'];

if ($captcha_id == 'field_79_area_35') {
	include('kcaptcha_other.php');
	$captcha = new KCAPTCHAOTHERBG();
} else {
	$captcha = new KCAPTCHA();
}
//if($_REQUEST[session_name()]){
	$_SESSION['captcha_'.$captcha_id] = $captcha->getKeyString();
//}
?>