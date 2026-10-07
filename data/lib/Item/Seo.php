<?php

namespace App\Item;

use App\Model;
use App\Query;
use App\Utils;

class Seo extends Model
{

    protected $table = 'item_seo';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';

    protected function prepareData()
    {
        //
    }

    protected function getData()
    {
        return [
            'data' => $this->data
        ];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }


    public static function check_url()
    {
        $get = Query::$get;
        if (!empty($get['url'])) {
            $url = $get['url'];
            unset($get['url']);
            if ($get) {
                ksort($get);
                $url .= '?';
                foreach ($get as $key => $val) {
                    $url .= $key . '=' . $val . '&';
                }
                $url = substr($url, 0, -1);
            }
            $item = self::getByKey('from', '/' . $url);
            if (!empty($item->id) && !empty($item->public)) {
                Utils::redirect($item->to);
            }
        }
    }

}

?>
