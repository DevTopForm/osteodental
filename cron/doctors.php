<?php
chdir(dirname(dirname(__FILE__)));

set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());

include('data/init.php');
//if (!Utils::detect_cli()) die('Access denied!');

$sitemap = new App\Site\Service\Cron\Doctors();
$sitemap->display();
?>