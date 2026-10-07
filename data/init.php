<?php
use App\Application;

ini_set('display_errors',1);
error_reporting(E_ERROR);

function pre(){
	echo '<pre>';
	print_r(func_num_args() > 1 ? func_get_args() : func_get_arg(0));
	echo '</pre>' . "\n";
}

function dumpQueries(){
	$db = Registry::get('db');
	$profiler = $db->getProfiler();
	pre($profiler->getQueryProfiles());
}


define('LIB_DIR', dirname(__FILE__).'/lib/');

require 'vendor/autoload.php';
require 'data/lib/Smarty/Plugins.php';

$php_version = explode('.', phpversion());
if ($php_version[0] >= 8) {
    mb_internal_encoding("UTF-8");
    Application::init();
} else {
    die('PHP 8.1.x or above is required.');
}