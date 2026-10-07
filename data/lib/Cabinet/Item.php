<?php

namespace App\Cabinet;

use App\RecordSet;
use App\Registry;
use App\Searcher;

class Item
{

    protected string $table = 'content_catalog';
    protected string $defaultSorter = 'id';
    protected string $defaultOrder = 'ASC';

    public array $errors = [];
    public int|null $id;

    protected array $serviceVars = ['table', 'defaultSorter', 'defaultOrder', 'errors', 'serviceVars', 'isCachable'];

    // конструктор объекта
    public function __construct($id = 0, $data = [])
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
                    $data = $db->query($this->getSelectTemplate())->execute()->current();
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

    // создание свойств в текущем объекте по массиву значений или копии объекта
    protected function loadData($data = []): void
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
    private function getSelectTemplate(): string
    {
        return sprintf(
            "SELECT * FROM `%s` WHERE id=%d",
            $this->table,
            $this->id
        );
    }

    // валидация объекта перед сохранением
    public function validate(): bool
    {
        return true;
    }

    // формирование данных объекта для вставки в базу
    protected function getData(): array
    {
        return [];
    }

    // сохранение объекта
    public function save(): void
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
    public function delete(): void
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
    public function toArray(): array
    {
        $fields = array_keys(get_object_vars($this));
        $values = [];
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
        $map_key = self::getVar('table') . '_map';
        if (!Registry::isRegistered($map_key)) {
            Registry::set($map_key, new Map());
        }
        return Registry::get($map_key);
    }

    // возвращает объект RecordSet содержащий выборку из базы в объектах
    public static function getList($parameters = [], $limiter = null, $class = 'Cabinet_Item'): RecordSet
    {
        $searcher = self::prepareSearcher($parameters, $limiter);
        try {
            $recordSet = $searcher->search();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $items = [];
        foreach ($recordSet->getItems() as $item) {
            $items[] = new $class($item['id'], $item);
        }

        $recordSet->setItems($items);

        return $recordSet;
    }

    // возвращает объект RecordSet содержащий выборку из базы
    public static function getListArray($parameters = [], $limiter = null): RecordSet
    {
        $searcher = self::prepareSearcher($parameters, $limiter);
        try {
            return $searcher->search();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    // настройки поиска
    public static function prepareSearcher($parameters, $limiter): Searcher
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

    public static function getByKey($key, $value, $class = 'Cabinet_Item')
    {
        try {
            $db = Registry::get('db');
            $item = $db->query(sprintf("SELECT * FROM %s WHERE `%s`=?", self::getVar('table'), $key), $value)->current(
            );
            if (!empty($item['id'])) {
                return new $class($item['id'], $item);
            }
        } catch (\Exception) {
        }
        return false;
    }

    public static function getListByKey($key, $value, $class = 'Cabinet_Item'): RecordSet
    {
        return self::getList(['filters' => [sprintf("%s='%s'", $key, $value)]], null, $class);
    }
}