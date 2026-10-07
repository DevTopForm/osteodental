<?php

namespace App;

use App\Cabinet\Map as CabinetMap;

class Item
{

    protected $table = 'items';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';

    public $errors = array();

    public $id;

    protected $serviceVars = array('table', 'defaultSorter', 'defaultOrder', 'errors', 'serviceVars', 'isCachable');

    // конструктор объекта
    public function __construct($id = 0, $data = array())
    {
        if (!empty($id)) {
            $map = $this->getIdentityMap();
            $item = $map->get($id);
            $this->id = $id;
            if (!empty($item)) {
                $this->loadData($item);
            } else {
                if (empty($data)) {
                    $db = Registry::get('db');
                    $data = $db->query($this->getSelectTemplate(), $db::QUERY_MODE_EXECUTE)->current();
                }
                if (!empty($data)) {
                    $this->loadData($data);
                    $this->prepareData();
                    $map->set($id, $this);
                } else {
                    $this->id = null;
                }
            }
        }
    }

    // создание свойств в текущем объекте по массиву значений или копиии объекта
    protected function loadData($data = array())
    {
        if (is_object($data)) {
            $vars = get_object_vars($data);
        } elseif (is_array($data)) {
            $vars = $data;
        } else {
            return;
        }
        foreach ($vars as $key => $value) {
            $this->$key = $value;
        }
    }

    // дополнительная обработка свойств объекта
    protected function prepareData()
    {
    }

    // шаблон получения отдельного элемента из базы
    private function getSelectTemplate()
    {
        return sprintf(
            "SELECT * FROM `%s` WHERE id=%d",
            $this->table,
            $this->id
        );
    }

    // валидация объекта перед сохранением
    public function validate()
    {
        return true;
    }

    // формирование данных объекта для вставки в базу
    protected function getData()
    {
        $data = array();
        return $data;
    }

    // сохранение объекта
    public function save()
    {
        $data = $this->getData();
        $db = Registry::get('db');
        if (!empty($this->id)) {
            $db->update($this->table, $data, 'id=' . $this->id);
            $this->updateAction();
        } else {
            $db->insert($this->table, $data);
            $this->id = $db->lastInsertId();
            $this->insertAction();
        }
    }

    //действия после обновления объекта
    protected function updateAction()
    {
    }

    //действия после добавления объекта
    protected function insertAction()
    {
    }

    // удаление объекта
    public function delete()
    {
        $this->prepareDelete();
        $db = Registry::get('db');
        $db->delete($this->table, sprintf('id = %s', $this->id));
    }

    // удаление связанных объектов, если потребуется
    protected function prepareDelete()
    {
    }

    // возвращает нестатическое свойство объекта как статическое
    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    //преобразование объекта в массив
    public function toArray()
    {
        $fields = array_keys(get_object_vars($this));
        $values = array();
        foreach ($fields as $field) {
            if (!in_array($field, $this->serviceVars)) {
                $values[$field] = $this->$field;
            }
        }
        return $values;
    }

    // возвращает карту уже существующих объектов по ключу
    protected function getIdentityMap()
    {
        $map_key = static::getVar('table') . '_map';
        if (!Registry::isRegistered($map_key)) {
            Registry::set($map_key, new CabinetMap($map_key));
        }
        return Registry::get($map_key);
    }

    // возвращает объект RecordSet содежащий выборку из базы в объектах
    public static function getList($parameters = array(), $limiter = null)
    {
        $class = get_called_class();

        $searcher = $class::prepareSearcher($parameters, $limiter, $class);
        $recordSet = $searcher->search();
        $items = array();
        foreach ($recordSet->getItems() as $item) {
            $items[] = new $class($item['id'], $item);
        }
        $recordSet->setItems($items);
        return $recordSet;
    }

    // возвращает объект RecordSet содежащий выборку из базы
    public static function getListArray($parameters = array(), $limiter = null)
    {
        $class = get_called_class();

        $searcher = $class::prepareSearcher($parameters, $limiter, $class);
        $recordSet = $searcher->search();
        return $recordSet;
    }

    // настройки поиска
    public static function prepareSearcher($parameters, $limiter, $class)
    {
        $settings = Registry::get('settings');
        $searcher = new Searcher();
        $searcher->setTable($class::getVar('table'));
        if (empty($parameters['sorters'])) {
            $parameters['sorters'] = array(
                sprintf(
                    '%s %s',
                    $class::getVar('defaultSorter'),
                    $class::getVar('defaultOrder')
                )
            );
        }
        if (is_null($limiter)) {
            $searcher->noPager();
        } elseif ((int)$limiter > 0) {
            $searcher->setPerPage($limiter);
        } else {
            $searcher->setPerPage($settings->getSiteParams('pager'));
        }
        $searcher->applySearchParameters($parameters);
        return $searcher;
    }

    public static function getByKey($key, $value)
    {
        $class = get_called_class();

        try {
            $db = Registry::get('db');
            $item = $db->query(
                sprintf("SELECT * FROM %s WHERE `%s`=?", $class::getVar('table'), $key),
                [$value]
            )->current();
            if (!empty($item['id'])) {
                return new $class($item['id'], $item);
            }
        } catch (\Exception $e) {
        }
        return false;
    }

    public static function getByKeys($filters = array())
    {
        $class = get_called_class();

        try {
            $db = Registry::get('db');
            $item = $db->query(
                sprintf(
                    "SELECT * FROM %s WHERE %s",
                    $class::getVar('table'),
                    ($filters ? implode(' AND ', $filters) : '')
                ),
                $db::QUERY_MODE_EXECUTE
            )->current();
            if (!empty($item['id'])) {
                return new $class($item['id'], $item);
            }
        } catch (\Exception $e) {
        }
        return false;
    }

    public static function getListByKey($key, $value, $limiter = null)
    {
        $class = get_called_class();

        return $class::getList(array('filters' => array(sprintf("%s='%s'", $key, $value))), $limiter = null, $class);
    }

    public static function simpleSave($id, $field, $value)
    {
        $db = Registry::get('db');
        $db->update(static::getVar('table'), array($field => $value), 'id=' . $id);
        if (static::getVar('isCachable')) {
            $cm = CacheManager::getInstance();
            $cm->removeCache(sprintf('%s_object_%s', static::getVar('table'), $id));
            $cm->removeCache(sprintf('%s_objects', static::getVar('table')));
        }
    }
}
