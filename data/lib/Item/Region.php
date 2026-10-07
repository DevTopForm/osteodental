<?php

namespace App\Item;

use App\Item;
use App\Message;
use App\Registry;
use App\Searcher;
use Exception;

class Region extends Item
{

    protected $table = 'item_region';
    protected $defaultSorter = 'title';
    protected $defaultOrder = 'ASC';

    protected function prepareData(): void
    {
        $this->link = $_SERVER['REQUEST_URI'] . '?set-region=1&region=' . $this->id;
    }

    protected function getData(): array
    {
        return [
            'title' => $this->title,
            'public' => empty($this->public) ? 0 : 1,
            'default' => empty($this->default) ? 0 : 1,
            'regionCode' => empty($this->regionCode) ? null : $this->regionCode,
            'dpd_key' => empty($this->dpd_key) ? null : $this->dpd_key
        ];
    }


    /**
     * @throws Exception
     */
    public static function getList($parameters = [], $limiter = null, $class = 'Item_Region')
    {
        $searcher = self::prepareSearcher($parameters, $limiter, $class);
        $recordSet = $searcher->search();
        $items = [];
        foreach ($recordSet->getItems() as $item) {
            $items[] = new $class($item['id'], $item);
        }
        $recordSet->setItems($items);
        return $recordSet;
    }


    /**
     * @throws Exception
     */
    public static function getListArray($parameters = [], $limiter = null, $class = 'Item_Region')
    {
        $searcher = self::prepareSearcher($parameters, $limiter, $class);
        return $searcher->search();
    }


    // настройки поиска
    public static function prepareSearcher($parameters, $limiter, $class): Searcher
    {
        $settings = Registry::get('settings');
        $searcher = new Searcher();
        $searcher->setTable(self::getVar('table'));
        if (empty($parameters['sorters'])) {
            $parameters['sorters'] = [sprintf('%s %s', self::getVar('defaultSorter'), self::getVar('defaultOrder'))];
        }
        if (is_null($limiter)) {
            $searcher->noPager();
        } elseif (is_int($limiter)) {
            $searcher->setPerPage($limiter);
        } else {
            $searcher->setPerPage($settings->getSiteParams('pager'));
        }
        $searcher->applySearchParameters($parameters);
        return $searcher;
    }

    public static function getByKey($key, $value, $class = 'Item_Region')
    {
        try {
            $db = Registry::get('db');
            $item = $db->fetchRow(sprintf("SELECT * FROM %s WHERE `%s`=?", self::getVar('table'), $key), $value);

            if (!empty($item['id'])) {
                return new $class($item['id'], $item);
            }
        } catch (Exception $e) {
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public static function getListByKey($key, $value, $limiter = null, $class = 'Region')
    {
        return self::getList(['filters' => [sprintf("%s='%s'", $key, $value)]], $limiter = null, $class);
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate(): bool
    {
        $valid = true;

        if (empty($this->title)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Город»', 'error');
        }
        if (empty($this->region)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Регион»', 'error');
        }
        if (empty($this->regionCode)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Код региона»', 'error');
        }

        return $valid;
    }
}