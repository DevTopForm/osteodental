<?php

namespace App\Node;

use App\CacheManager;
use App\Message;
use App\Model;
use App\Node\Field\Item;
use App\Node\Catalog\Item as CatalogItem;
use App\Node\Setting\Value;
use App\Node\Variant\Field as VariantField;
use App\Node\Catalog\Field as CatalogField;
use App\Node\Variant\Field\Item as VariantFieldItem;
use App\Node\Setting\Field\Item as SettingFieldItem;
use App\Node\Type\Template as TypeTemplate;
use App\Params;
use App\Registry;

class Type extends Model
{

    protected $table = 'nodes_types';
    protected $defaultSorter = 'sorter';
    protected $isCachable = true;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'has_content' => empty($this->has_content) ? 0 : 1,
            'has_items' => empty($this->has_items) ? 0 : 1,
            'sorter' => empty($this->sorter) ? 0 : $this->sorter,
            'sortable' => empty($this->sortable) ? 0 : $this->sortable,
            'in_block' => empty($this->in_block) ? 0 : $this->in_block,
            'in_node' => empty($this->in_node) ? 0 : $this->in_node,
            'search' => empty($this->search) ? 0 : 1,
            'has_filters' => empty($this->has_filters) ? 0 : 1,
            'has_variants' => empty($this->has_variants) ? 0 : 1,
            'has_compare' => empty($this->has_compare) ? 0 : 1,
            'is_catalog' => empty($this->is_catalog) ? 0 : 1
        ];
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->type)) {
            $valid = false;
            $this->errors['type'] = new Message('Необходимо заполнить поле Сервисное имя', 'error');
        }
        return $valid;
    }


    //действия после обновления объекта
    protected function updateAction()
    {
        //try {
        $db = Registry::get('db');

        if (!empty($this->old_has_content) && empty($this->has_content)) {
            $db->query(sprintf("DROP TABLE `content_%s`", $this->type), $db::QUERY_MODE_EXECUTE);
            // удаление данных о полях
            $fields = Item::getListByKey('type', $this->type)->getItems();
            foreach ($fields as $field) {
                $field->delete();
            }
        } elseif (empty($this->old_has_content) && !empty($this->has_content)) {
            $this->insertAction();
        }

        //варианты
        if (!empty($this->old_has_variants) && empty($this->has_variants)) {
            $db->query(sprintf("DROP TABLE `content_%s_variant`", $this->type), $db::QUERY_MODE_EXECUTE);
            // удаление данных о полях
            $fields = VariantFieldItem::getListByKey('type', $this->type)->getItems();
            foreach ($fields as $field) {
                $field->delete();
            }
        } elseif (!empty($this->has_content) && empty($this->old_has_variants) && !empty($this->has_variants)) {
            // Создание таблицы
            $db->query(
                sprintf(
                    "CREATE TABLE IF NOT EXISTS `content_%s_variant` (
					`id` INT(11) NOT NULL AUTO_INCREMENT,
					`item` INT(11) NOT NULL,
					PRIMARY KEY(`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;",
                    $this->type
                ),
                $db::QUERY_MODE_EXECUTE
            );
        }
    }

    //действия после добавления объекта
    protected function insertAction()
    {
        try {
            $db = Registry::get('db');
            if (!empty($this->has_content)) {
                // Создание таблицы
                $db->query(
                    sprintf(
                        "CREATE TABLE IF NOT EXISTS `content_%s` (
					`id` INT(11) NOT NULL AUTO_INCREMENT,
					`node` INT(11) NOT NULL,
					PRIMARY KEY(`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;",
                        $this->type
                    ),
                    $db::QUERY_MODE_EXECUTE
                );

                if(!empty($this->is_catalog)) {
                    foreach (CatalogItem::$default_fields as $itemKey => $itemValue) {
                        $item = new Item();

                        foreach ($itemValue as $fieldKey => $fieldValue) {
                            $item->$fieldKey = $fieldValue;
                        }

                        $item->name = $itemKey;
                        $item->type = $this->type;

                        if ($item->validate()) {
                            $item->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }

    // удаление связанных объектов, если потребуется
    protected function prepareDelete()
    {
        // Удаление таблицы контента
        if ($this->has_content) {
            // удаление данных о полях
            $fields = Item::getListByKey('type', $this->type)->getItems();
            foreach ($fields as $field) {
                $field->delete();
            }

            try {
                $db = Registry::get('db');
                $db->query(sprintf("DROP TABLE `content_%s`", $this->type), $db::QUERY_MODE_EXECUTE);
            } catch (\Exception $e) {
                pre($e->getMessage());
            }
        }
        //Удаление вариантов
        if ($this->has_variants) {
            // удаление данных о полях
            $fields = VariantFieldItem::getListByKey('type', $this->type)->getItems();
            foreach ($fields as $field) {
                $field->delete();
            }

            try {
                $db = Registry::get('db');
                $db->query(sprintf("DROP TABLE `content_%s_variant`", $this->type), $db::QUERY_MODE_EXECUTE);
            } catch (\Exception $e) {
                pre($e->getMessage());
            }
        }

        // удаление данных о параметрах
        $params = SettingFieldItem::getListByKey('type', $this->type)->getItems();
        foreach ($params as $param) {
            $param->delete();
        }

        // удаление значаний параметров
        $values = Value::getListByKey('type', $this->type)->getItems();
        foreach ($values as $value) {
            $value->delete();
        }

        //удаление шаблонов
        $dir = Params::$params['root_path'] . 'templates/common/module/' . $this->type;
        $tpls = TypeTemplate::getListByKey('type', $this->type)->getItems();
        foreach ($tpls as $tpl) {
            //if(is_file($dir.$tpl->file)) unlink($dir.$tpl->file);
            $tpl->delete();
        }
        //for special tpls item.tpl, category.tpl..
        $sys_tpls = glob($dir . "/*");
        if ($sys_tpls) {
            foreach ($sys_tpls as $sys_tpl) {
                unlink($sys_tpl);
            }
        }
        rmdir($dir);

        //удаление файла модуля шаблонов
        $modile_file = LIB_DIR . '/Module/' . ucfirst($this->type) . '.class.php';
        if (file_exists($modile_file)) {
            unlink($modile_file);
        }
        //удадение картинок и записей о них
        //удадение нодов
    }

    public function getFields()
    {
        if (!empty($this->fields)) {
            return $this->fields;
        }

        $this->fields = Field::getList($this->type);
        return $this->fields;
    }

    public function getCatalogFields()
    {
        if (!empty($this->catalogFields)) {
            return $this->catalogFields;
        }

        $this->catalogFields = CatalogField::getList($this->type);
        return $this->catalogFields;
    }

    public function getVariantFields()
    {
        if (!empty($this->variantFields)) {
            return $this->variantFields;
        }
        $this->variantFields = VariantField::getList($this->type);
        return $this->variantFields;
    }

    public function getFieldsItems()
    {
        if (!empty($this->fielditems)) {
            return $this->fielditems;
        }
        $this->fielditems = Item::getListByKey('type', $this->type)->getItems();
        return $this->fielditems;
    }

    public function getTable()
    {
        return 'content_' . $this->type;
    }

    public static function getByKey($key, $value)
    {
        if ($key == 'type' && static::getVar('isCachable')) {
            $cache_id = sprintf('%s_key_%s_%s', static::getVar('table'), $key, $value);
            $cm = CacheManager::getInstance();
            $item = $cm->getCache($cache_id);
            if (empty($item)) {
                $item = static::getByKeys([$key => $value]);
                $cm->setCache($cache_id, $item, static::getVar('cacheTime'));
            }
            return $item;
        } else {
            return static::getByKeys([$key => $value]);
        }
    }

    protected function updateCache()
    {
        if ($this->isCachable) {
            $cm = CacheManager::getInstance();
            $cm->removeCache(sprintf('%s_key_type_%s', static::getVar('table'), $this->type));
            $cm->removeCache(sprintf('%s_object_%s', static::getVar('table'), $this->id));
            $cm->removeCache(sprintf('%s_objects', static::getVar('table')));
        }
    }

}

?>
