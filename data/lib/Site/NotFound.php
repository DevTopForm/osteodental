<?php
namespace App\Site;

use App\Template;

class NotFound{
    private static $instance = null;

    private function __construct(){
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function parse(){
        $tpl = new Template();
        return $tpl->fetch('service/404.tpl');
    }
}