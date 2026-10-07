<?php

namespace App\Node;

use App\Attach;
use App\Image;
use App\Model;
use App\Node;
use App\Query;
use App\Registry;
use App\Node\Variant\Item as NodeVariantItem;

class Item extends Model
{

    public $node_fields = array();
    protected $undelete = ['image', 'images'];
    public static $itemsTable = null;

    public function __construct($table, $id = 0, $data = array())
    {
        $this->table = $table;
        parent::__construct($id, $data);
    }

    protected function prepareData()
    {
        $this->node = new Node($this->node);
    }

    /*
    итемы все хранятся в разных таблицах, поэтому при вызове выборки по итемам должно быть установлено статическое свойство itemsTable (таблица из которой берутся данные об итемах), иначе будет Exception
    */
    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        if ($name == 'table') {
            if (!empty(static::$itemsTable)) {
                return static::$itemsTable;
            }
            throw new \Exception('Empty node items table');
        }
        return $fields[$name];
    }

    public function getTable()
    {
        return static::$itemsTable;
    }

    public function setFields($fields)
    {
        foreach ($fields as $field) {
            $name = $field->name;
            if (isset($this->$name)) {
                $field->setValue($this->$name);
            }
            $this->nodes_fields[] = $field;
        }
    }

    protected function getData()
    {
        $data = array(
            'node' => $this->node->id,
        );

        if (empty($this->nodes_fields)) {
            $this->setFields($this->node->getFields());
        }

        foreach ($this->nodes_fields as $key => $field) {
            if (
                empty(Query::$request['not_copy'])
                && $field->name === "node"
            ) {
                continue;
            }
            
            $data[$field->name] = $field->getValue();
        }

        return $data;
    }

    public function validate()
    {
        $valid = true;
        foreach ($this->nodes_fields as $key => $field) {
            if (array_search($field->name, $this->undelete) !== false) {
                $field->removeAttach();
            }
            $messages = $field->validate();

            if (!empty($messages)) {
                $valid = false;
                $this->errors[$field->name] = implode('<br>', array_column($messages, 'html'));
            }
            if ($field->name == 'alias') {
                $field->setValue($this->checkAlias($field->getValue()));
            }

//            if ($field->name == 'title') {
//                if (!$this->checkTitle($field->getValue())) {
//                    $this->errors['title'] = new Message('{$_LNG_ADM.UNIQUE}', 'error');
//                    $valid = false;
//                }
//            }

            $this->nodes_fields[$key] = $field;
        }
        return $valid;
    }

    public function simpleUpdate($field, $value)
    {
        $db = Registry::get('db');
        $update = $db->sql->update();
        $update->table($this->table);
        $update->set([$field => $value]);
        $update->where('id=' . $this->id);
        $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        //$db->update($this->table,array($field => $value),'id='.$this->id);
    }

    public function prepareDelete()
    {
        $fields = $this->node->getFields();
        foreach ($fields as $field) {
            $name = $field->name;
            $type = $field->type;
            if ($type == 'multiimage' && !empty($this->$name)) {
                $images = explode(';', $this->$name);
                foreach ($images as $image) {
                    $image = new Image($image);
                    $image->delete();
                }
            } elseif (in_array($type, array('image', 'file', 'simplefile')) && !empty($this->$name)) {
                $attach = Attach::factory($type, $this->$name);
                $attach->delete();
            }
        }
    }

    public static function getByAlias($alias, $node)
    {
        $db = Registry::get('db');
        $item = $db->query(
            sprintf("SELECT * FROM %s WHERE `alias` = ? AND `node` = ? LIMIT 1", $node->getTable()),
            array($alias, $node->id)
        )->current();
        if (!empty($item)) {
            return new static($node->getTable(), $item['id'], $item);
        }
        return null;
    }


    // возвращает объект RecordSet содежащий выборку из базы в объектах
    public static function getList($parameters = array(), $limiter = null)
    {
        $searcher = static::prepareSearcher($parameters, $limiter);
        $recordSet = $searcher->search();
        $items = array();
        foreach ($recordSet->getItems() as $item) {
            $items[] = new static(static::getVar('table'), $item['id'], $item);
        }
        $recordSet->setItems($items);
        return $recordSet;
    }

    public static function getByKeys($data = array())
    {
        $db = Registry::get('db');
        if (!empty($data)) {
            list($filters, $values) = static::prepareFiltersArray($data);
            $item = $db->query(
                sprintf("SELECT * FROM `%s` WHERE %s LIMIT 1", static::getVar('table'), join(' AND ', $filters)),
                $values
            )->current();
        } else {
            $item = $db->query(sprintf("SELECT * FROM `%s` WHERE 1 LIMIT 1", static::getVar('table')))->execute()->current();
        }
        if (!empty($item['id'])) {
            return new static(static::getVar('table'), $item['id'], $item);
        }
        return false;
    }

    public function getUrl()
    {
        if (empty($this->url)) {
            $this->url = $this->node->getUrl() . (empty($this->alias) ? "" : ('/' . $this->alias));
        }
        return $this->url;
    }

    protected function checkAlias($alias)
    {
        $postfix = 0;
        $params = [
            'alias' => $alias,
            'node' => $this->node->id
        ];

        if (!empty($this->id)) {
            $params['!id'] = (int)$this->id;
        }
        static::$itemsTable = $this->node->getTable();
        $exists = static::getByKeys($params);
        while ($exists) {
            $params['alias'] = $alias . '_' . ++$postfix;
            $exists = static::getByKeys($params);
        }
        return $params['alias'];
    }

    protected function checkTitle($title)
    {
        $params = [
            'title' => $title,
            'node' => $this->node->id
        ];

        if (!empty($this->id)) {
            $params['!id'] = (int)$this->id;
        }

        static::$itemsTable = $this->node->getTable();
        $exists = static::getByKeys($params);
        if ($exists) {
            return false;
        }
        return true;
    }

    public function getVariants()
    {
        if (empty($this->id) || empty($this->node->type->has_variants)) {
            return array();
        }

        NodeVariantItem::$itemsTable = $this->node->getTable() . '_variant';
        $parameters['filters'][] = '`item` = ' . $this->id;
        return NodeVariantItem::getList($parameters, null)->getItems();
    }
}
