<?php

namespace App\Node\Variant\Field;

use App\Node\Field\Item as NodeFieldItem;
use App\Registry;

class Item extends NodeFieldItem
{

    protected $table = 'nodes_variant_fields';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    //действия после обновления объекта
    protected function updateAction()
    {
        try {
            $db = Registry::get('db');
            if (!empty($this->oldname)) {
                $db->query(
                    sprintf(
                        "ALTER TABLE `content_%s_variant` CHANGE `%s` `%s` %s",
                        $this->type,
                        $this->oldname,
                        $this->name,
                        static::$types[$this->field]
                    )
                )->execute();
            } else {
                $db->query(
                    sprintf(
                        "ALTER TABLE `content_%s_variant` ADD `%s` %s",
                        $this->type,
                        $this->name,
                        static::$types[$this->field]
                    )
                )->execute();
            }
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    //действия после добавления объекта
    protected function insertAction()
    {
        try {
            $db = Registry::get('db');
            $db->query(
                sprintf(
                    "ALTER TABLE `content_%s_variant` ADD `%s` %s",
                    $this->type,
                    $this->name,
                    static::$types[$this->field]
                )
            )->execute();
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    // удаление связанных объектов, если потребуется
    protected function prepareDelete()
    {
        try {
            $db = Registry::get('db');
            $db->query(sprintf("ALTER TABLE `content_%s_variant` DROP `%s`", $this->type, $this->name))->execute();
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    protected function getData()
    {
        $data = parent::getData();
        unset($data['compare_field']);
        unset($data['property_show']);
        unset($data['property_list_show']);
        unset($data['property_list_show_mobile']);
        return $data;
    }
}

?>
