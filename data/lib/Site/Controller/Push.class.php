<?php

class Site_Controller_Push extends Site_Controller_Abstract{

    protected $model = [
        'tlg' => "Site_Telegram"
    ];

    public function isDispatchable($pathStr){
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match(
            '/^push\/.*$/',
            $pathStr
        );
    }

    public function run(){
        if(count($this->path) < 2 || empty($this->model[$this->path[1]])){
            header('HTTP/1.0 403 Forbidden');
            die;
        }

        $model = new $this->model[$this->path[1]];
        $model->run();
    }
}
