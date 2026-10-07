<?php

namespace App\Node\Field;

use App\CacheManager;
use App\Message;
use App\Model;
use App\Node\Type;
use App\Registry;
use Exception;

class Item extends Model
{

    protected $table = 'nodes_fields';
    protected $defaultSorter = 'weight';
    protected $isCachable = true;

    public static $types = array(
        'text' => "TEXT NOT NULL",
        'textarea' => "TEXT NOT NULL",
        'checkbox' => "TINYINT(1) NOT NULL DEFAULT 0",
        'image' => "INT(11) NOT NULL DEFAULT 0",
        'date' => "DATETIME DEFAULT NULL",
        'integer' => "INT(11) NOT NULL DEFAULT 0",
        'smalltext' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'medtext' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multiselect' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multisel2area' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multitext' => "TEXT NOT NULL",
        'select' => "INT(11) NOT NULL DEFAULT 0",
        'file' => "INT(11) NOT NULL DEFAULT 0",
        'multiimage' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'yapoint' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multifile' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'alias' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'hidden' => "INT(11) NOT NULL DEFAULT 0",
        'simplefile' => "INT(11) NOT NULL DEFAULT 0",
        'variant' => "INT(11) NOT NULL DEFAULT 0",
        'properties' => "JSON NULL DEFAULT NULL",
        'complex' => "JSON NULL DEFAULT NULL",
    );

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        $data = array(
            'type' => $this->type,
            'name' => $this->name,
            'title' => $this->title,
            'field' => $this->field,
            'example' => empty($this->example) ? '' : $this->example,
            'editor' => empty($this->editor) ? 0 : 1,
            'format' => empty($this->format) ? '' : $this->format,
            'show' => empty($this->show) ? 0 : 1,
            'required' => empty($this->required) ? 0 : 1,
            'weight' => empty($this->weight) ? 0 : $this->weight,
            'table_data' => empty($this->table_data) ? '' : $this->table_data,
            'table_filter' => empty($this->table_filter) ? '' : $this->table_filter,
            'table_value' => empty($this->table_value) ? '' : $this->table_value,
            'sorter' => empty($this->sorter) ? 0 : $this->sorter,
            'sorteri' => empty($this->sorteri) ? 0 : $this->sorteri,
            'default' => empty($this->default) ? '' : $this->default,
            'disabled' => empty($this->disabled) ? 0 : 1,
            'prepare' => empty($this->prepare) ? '' : $this->prepare,
            'unique' => empty($this->unique) ? 0 : 1,
            'advanced' => empty($this->advanced) ? 0 : 1,
            'search' => empty($this->search) ? 0 : 1,
            'inlist' => empty($this->inlist) ? 0 : 1,
            'compare_field' => empty($this->compare_field) ? 0 : 1,
            'property_show' => empty($this->property_show) ? 0 : 1,
            'property_list_show' => empty($this->property_list_show) ? 0 : 1,
            'property_list_show_mobile' => empty($this->property_list_show_mobile) ? 0 : 1,
            'filter_show' => empty($this->filter_show) ? 0 : 1,
            'node_group' => empty($this->node_group) ? 0 : $this->node_group,
        );
        return $data;
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->type)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо указать тип раздела', 'error');
        }
        if (empty($this->name)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле "Имя в таблице"', 'error');
        }
        if (empty($this->field)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать тип поля', 'error');
        }
        if (!array_key_exists($this->field, static::$types)) {
            $valid = false;
            $this->errors[] = new Message('Указан недопустимый тип поля', 'error');
        }
        return $valid;
    }

    //действия после обновления объекта
    protected function updateAction()
    {
        try {
            $db = Registry::get('db');
            if (!empty($this->oldname)) {
                $db->query(
                    sprintf(
                        "ALTER TABLE `content_%s` CHANGE `%s` `%s` %s",
                        $this->type,
                        $this->oldname,
                        $this->name,
                        static::$types[$this->field]
                    )
                )->execute();
            } else {
                $db->query(
                    sprintf(
                        "ALTER TABLE `content_%s` ADD `%s` %s",
                        $this->type,
                        $this->name,
                        static::$types[$this->field]
                    )
                )->execute();
            }
        } catch (Exception $e) {
            pre($e->getMessage());
        }
    }

    //действия после добавления объекта
    protected function insertAction()
    {
        try {
            $type = Type::getByKey('type', $this->type);

            $db = Registry::get('db');
            $db->query(
                sprintf("ALTER TABLE `content_%s` ADD `%s` %s", $this->type, $this->name, static::$types[$this->field])
            )->execute();
        } catch (Exception $e) {
            pre($e->getMessage());
        }
    }

    // удаление связанных объектов, если потребуется
    protected function prepareDelete()
    {
        try {
            $type = Type::getByKey('type', $this->type);

            if(!empty($type->is_catalog)){
                return false;
            }

            $db = Registry::get('db');
            $db->query(sprintf("ALTER TABLE `content_%s` DROP `%s`", $this->type, $this->name))->execute();
        } catch (Exception $e) {
            pre($e->getMessage());
        }
    }

    public function cacheOff()
    {
        $this->isCachable = false;
        return 0;
    }

    public function list($parameters = array(), $limiter = null)
    {
        $getCache = false;
        if ($this->isCachable) {
            $getCache = true;
        }

        $cache_id = static::getVar('table') . '_objects_' . md5(json_encode($parameters ?? '')) . '_' . md5($limiter ?? 0);

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
}

?>
