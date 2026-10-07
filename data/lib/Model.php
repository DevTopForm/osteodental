<?php

namespace App;

class Model
{

    protected $table = '';
    protected $historyTable = 'element_temp_storage';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';
    protected $isCachable = false;
    protected $cacheTime = 86400;
    public $errors = array();
    protected $serviceVars = array(
        'table',
        'defaultSorter',
        'defaultOrder',
        'errors',
        'serviceVars',
        'isCachable',
        'cacheTime'
    );

    // конструктор объекта
    public function __construct($id = 0, $data = array())
    {
        if (!empty($id)) {
            $map = $this->getIdentityMap();
            $item = $map->get($id . $this->table);
            $this->id = $id;
            if (!empty($item) && empty($data)) {
                $this->loadData($item);
            } else {
                if (empty($data)) {
                    $data = $this->getCacheItem($id . $this->table);
                }
                if (!empty($data)) {
                    $this->loadData($data);
                    $this->prepareData();
                    $map->set($id . $this->table, $this);
                } else {
                    $this->id = null;
                }
            }
        }
    }

    protected function getCacheItem($id)
    {
        if ($this->isCachable) {
            $cache_id = sprintf('%s_object_%s', static::getVar('table'), $id);
        } else {
            $cache_id = null;
        }
        $data = array();
        if ($this->isCachable) {
            $cm = CacheManager::getInstance();
            $data = $cm->getCache($cache_id);
        }
        if (empty($data)) {
            $db = Registry::get('db');
            $data = $db->query($this->getSelectTemplate())->execute()->current();
            if ($this->isCachable) {
                $cm->setCache($cache_id, $data, $this->cacheTime);
            }
        }
        return $data;
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
    protected function getSelectTemplate()
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
        $valid = true;
        return $valid;
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
            $update = $db->sql->update();
            $update->table($this->table);
            $update->set($data);
            $update->where('id=' . "$this->id");
            $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
            $this->updateAction();
        } else {
            $insert = $db->sql->insert();
            $insert->into($this->table);
            $insert->columns(array_keys($data));
            $insert->values($data);
            $db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
            $this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();
            $this->insertAction();
        }
        $this->updateCache();
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
        if (empty($this->id)) {
            return;
        }
        $this->prepareDelete();
        $db = Registry::get('db');
        $delete = $db->sql->delete();
        $delete->from($this->table);
        $delete->where(sprintf('id = %s', $this->id));
        $db->query($db->sql->buildSqlString($delete), $db::QUERY_MODE_EXECUTE);
        $this->updateCache();
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
        $map_key = $this->table . '_map';
        if (!Registry::isRegistered($map_key)) {
            Registry::set($map_key, new Map($map_key));
        }
        return Registry::get($map_key);
    }

    // возвращает объект RecordSet содежащий выборку из базы в объектах
    public static function getList($parameters = array(), $limiter = null)
    {
        $getCache = false;
        /* старый вариант кэширования
        if (static::getVar('isCachable') && empty($parameters) && empty($limiter)){
            $getCache = true;
        }
        $cache_id = sprintf('%s_objects',static::getVar('table'));
        */

        if (static::getVar('isCachable')) {
            $getCache = true;
        }

        $cache_id = static::getVar('table') . '_objects_' . md5(json_encode($parameters)) . '_' . md5($limiter ?? 0);

        $recordSet = null;
        if ($getCache) {
            $cm = CacheManager::getInstance();
            $recordSet = $cm->getCache($cache_id);
        }
        if (empty($recordSet)) {
            $searcher = static::prepareSearcher($parameters, $limiter);
            $recordSet = $searcher->search();
            $items = array();
            foreach ($recordSet->getItems() as $item) {
                $items[] = new static($item['id'], $item);
            }
            $recordSet->setItems($items);

            if ($getCache) {
                $cm->setCache($cache_id, $recordSet, static::getVar('cacheTime'));
            }
        }
        return $recordSet;
    }

    // возвращает объект RecordSet содежащий выборку из базы
    public static function getListArray($parameters = array(), $limiter = null)
    {
        $searcher = static::prepareSearcher($parameters, $limiter);
        $recordSet = $searcher->search();
        return $recordSet;
    }

    // настройки поиска
    public static function prepareSearcher($parameters, $limiter)
    {
        $searcher = new Searcher();
        $searcher->setTable(static::getVar('table'));
        if (empty($parameters['sorters'])) {
            $parameters['sorters'] = array(
                sprintf(
                    '%s %s',
                    static::getVar('defaultSorter'),
                    static::getVar('defaultOrder')
                )
            );
        }
        if (is_null($limiter)) {
            $searcher->noPager();
        } elseif (is_numeric($limiter)) {
            $searcher->setPerPage($limiter);
        } else {
            $searcher->setPerPage(25);
        }
        $searcher->applySearchParameters($parameters);
        return $searcher;
    }

    public static function getByKey($key, $value)
    {
        return static::getByKeys(array($key => $value));
    }

    public static function getByKeys($data = array())
    {
        $db = Registry::get('db');
        if (!empty($data)) {
            list($filters, $values) = static::prepareFiltersArray($data);
            $item = $db->query(
                sprintf("SELECT * FROM `%s` WHERE %s", static::getVar('table'), join(' AND ', $filters)),
                $values
            )->current();
        } else {
            $item = $db->query(sprintf("SELECT * FROM `%s` WHERE 1", static::getVar('table')))->execute()->current();
        }
        if (!empty($item['id'])) {
            return new static($item['id'], $item);
        }
        return false;
    }

    protected static function prepareFiltersArray($data)
    {
        $filters = array();
        $values = array();
        foreach ($data as $key => $value) {
            if ($key[0] == '!') {
                $expr = '<>';
                $key = str_replace('!', '', $key);
            } else {
                $expr = '=';
            }
            $filters[] = sprintf('`%s` %s ?', $key, $expr);
            $values[] = $value;
        }
        return array($filters, $values);
    }

    public static function getListByKey($key, $value, $limiter = null)
    {
        return static::getList(array('filters' => array(sprintf("%s='%s'", $key, $value))), $limiter);
    }

    public static function simpleSave($id, $field, $value)
    {
        $db = Registry::get('db');
        $update = $db->sql->update();
        $update->table(static::getVar('table'));
        $update->set(array($field => $value));
        $update->where('id=' . $id);
        $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        //$db->update(static::getVar('table'),array($field => $value),'id='.$id);
        if (static::getVar('isCachable')) {
            $cm = CacheManager::getInstance();
            $cm->removeCache(sprintf('%s_object_%s', static::getVar('table'), $id));
            $cm->removeCache(sprintf('%s_objects', static::getVar('table')));
        }
    }

    protected function updateCache()
    {
        if ($this->isCachable) {
            $cm = CacheManager::getInstance();
            $cm->removeCache(sprintf('%s_object_%s', static::getVar('table'), $this->id));
            $cm->removeCache(sprintf('%s_objects', static::getVar('table')));
        }
    }
}
