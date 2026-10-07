<?php
namespace App\Node;

use App\Node\Setting\Field;
use App\Registry;

class Setting
{

    protected $table = 'nodes_params_fields';
    protected $options_table = 'nodes_params_fields_options';

    protected static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public static function getFieldsList($params = array())
    {
        $data = self::getList($params);
        $fields = array();
        foreach ($data as $field) {
            $fields[] = new Field($field);
        }
        return $fields;
    }

    protected static function getList($params = array())
    {
        $db = Registry::get('db');
        $select = $db->sql->select()->from(self::getVar('table'))->order('weight ASC');
        /*foreach ($params as $key => $value){
            $select->where($key.' = ?', $value);
        }*/
        $select->where($params);
        return $db->query($db->sql->buildSqlString($select), [])->toArray();
    }

}

?>
