<?php

namespace App\Admin\Controller\Ajax;

use App\Query;
use App\Registry;
use App\Utils;

class Multiselect extends Action
{

    protected $tpl = 'ajax/area.tpl';

    public function run()
    {

        $filter = [
            'public' => 'public = 1'
        ];

        if(!empty(Query::$get['field']) && !empty(Query::$get['value'])){
            $filter[Query::$get['field']] = sprintf('%s = "%s"', Query::$get['field'], Query::$get['value']);
        }

        if(!empty(Query::$get['title'])){
            $filter['title'] = sprintf('title like "%%%s%%"', Query::$get['title']);
        }

        $db = Registry::get('db');

        $result = $db->query(
            sprintf('SELECT `id`, `title`  FROM `%s`  WHERE %s', Query::$get['table'], implode(' AND ', $filter)),
            $db::QUERY_MODE_EXECUTE
        )->toArray();

        Utils::jsonPage($result);
    }
}