<?php
	chdir(dirname(dirname(__FILE__)));

	set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());

	include('data/init.php');

	$api = new Api_Request();
	$api->run();
?>
