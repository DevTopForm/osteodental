<?php
chdir(dirname(dirname(__FILE__)));

set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());

include('data/init.php');

$mailer = new Site_Service_Message_Telegram();
//$result = $mailer->sendMessage("hahaha", 568502371);
//$result = $mailer->getChatMember();
$result = $mailer->getUpdates();
?>
