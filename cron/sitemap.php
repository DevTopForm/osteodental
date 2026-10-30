#!/usr/local/bin/php
<?php
	chdir(dirname(dirname(__FILE__)));

	set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());

    if(empty($_SERVER['DOCUMENT_ROOT'])){
        $_SERVER['DOCUMENT_ROOT'] = getcwd();
    }

if(empty($_SERVER['HTTP_HOST'])){
    $_SERVER['HTTP_HOST'] = 'osteodental.ru';
}

	include(getcwd() . '/data/init.php');
	//if (!Utils::detect_cli()) die('Access denied!');

	$sitemap = new \App\Site\Service\Cron\Sitemap();
	$sitemap->run();
?>
