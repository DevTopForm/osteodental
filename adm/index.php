<?php

use App\CacheManager;
use App\Admin\Frontend;

set_include_path(dirname(dirname(__FILE__)).'/data/lib' . PATH_SEPARATOR . get_include_path());

if (!empty($_POST['PHPSESSID'])){
	session_id($_POST['PHPSESSID']);
}
header('Content-type: text/html; charset=UTF-8');
chdir('../');
include('data/init.php');
CacheManager::clear_cache();

$q = trim(@$_SERVER['REQUEST_URI']);
list($q) = explode('?', $q);
list($q) = explode('index.php', $q);
$_REQUEST['q'] = $q;

$q = explode('/', trim(@$_REQUEST['q'], '/'));

$fc = new Frontend();
try {
	define('ADMIN_PATH_PREFIX', '/adm');
	echo $fc->run();
} catch (\Exception $e) {
	pre($e->getMessage());
}
?>
