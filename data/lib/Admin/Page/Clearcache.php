<?php

namespace App\Admin\Page;

use App\CacheManager;
use App\Query;

class Clearcache extends LAVED
{
    protected $localTpl = 'content/clearcache.tpl';
    protected $action = 'clearcache';

    protected function setItemFields()
    {
    }

    protected function executeRequestProcessing()
    {
        CacheManager::clear_cache();

        ob_clean();
        echo "Операция успешно выполнена";
        die();

//        if(!empty(Query::$get['page'])){
//            header(sprintf('location: %s', Query::$get['page']));
//        }
    }

    protected function getItem()
    {
    }

    protected function getItemsList()
    {
    }
}
