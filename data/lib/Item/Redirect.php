<?php

namespace App\Item;

use App\Model;
use App\Query;
use App\Utils;
use App\Message;

class Redirect extends Model
{

    protected $table = 'item_redirect';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';

    protected function prepareData()
    {
        //
    }

    protected function getData()
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'public' => empty($this->public) ? 0 : 1
        ];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->from)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Откуда»', 'error');
        } elseif (!preg_match('/^\//', $this->from)) {
            $valid = false;
            $this->errors[] = new Message('Поле «Откуда» должно начинаться с «/»', 'error');
        }
        if (empty($this->to)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Куда»', 'error');
        }
        return $valid;
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
                    if (is_array($val)) {
                        continue;
                    }
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
