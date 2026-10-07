<?php
    
use App\Query;
use App\Utils;
use App\Item\Redirect;
use App\Frontend;
use App\Cabinet\Frontend as FrontendCabinet;

set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());

header('Content-type: text/html; charset=UTF-8');
include('data/init.php');

if (!empty(Query::$get['page_id'])) {
    Utils::redirect('/');
}

Redirect::check_url();

$q = trim(@$_SERVER['REQUEST_URI']);
list($q) = explode('?', $q);
list($q) = explode('index.php', $q);
$_REQUEST['q'] = $q;

$q = explode('/', trim(@$_REQUEST['q'], '/'));

$path = $q[0];
switch ($path) {
    case "cabinet":
        define('CABINET_PATH_PREFIX', '/cabinet');
        $fc = new FrontendCabinet();
        break;
    default:
        define('SITE_PATH_PREFIX', '/');
        $fc = new Frontend();
        break;
}

try {
    echo $fc->run();
} catch (Exception $e) {
    pre($e->getMessage());
    die;
}