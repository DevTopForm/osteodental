<?php

namespace App\Site\Setting;

use App\Field as AppField;
use App\Form\Field as FormField;
use App\Params;
use App\Registry;

class Field extends AppField
{

    protected static $fields_table = 'site_params_fields';
    protected static $option_table = 'site_params_fields_options';

    public function __construct($data = array(), $id = 0)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            if (!empty($this->options)) {
                $db = Registry::get('db');
                if (!empty($this->table)) {
                    try {
                        $data = $db->query(
                            sprintf(
                                "
							SELECT `id`,`title`, `id` AS `value`
							FROM `%s`
							WHERE `public` = 1
							ORDER BY `title` ASC
						",
                                $this->table
                            )
                        )->execute()->toArray();
                        if (!empty($data)) {
                            $this->options_data = $data;
                        }
                    } catch (\Exception $e) {
                        die("Table $this->table does not exist");
                    }
                } else {
                    $data = $db->query(
                        sprintf(
                            "
						SELECT `id`,`title`,`value`
						FROM `%s`
						WHERE `fid` = '%s'
						ORDER BY `weight`,`title` ASC
					",
                            self::getVar('option_table'),
                            $this->id
                        )
                    )->execute()->toArray();

                    if (!empty($data)) {
                        $this->options_data = $data;
                    }
                }
            }
            if (empty(Params::$params['advanced']) && !empty($this->advanced)) {
                $this->type = 'hidden';
            }
            $this->form_field = FormField::factory($this);
        } else {
            if (!empty($id)) {
                $db = Registry::get('db');
                $this->id = $id;
                $data = (empty($data)) ? $db->query($this->getSelectTemplate())->execute()->current() : $data;
                if (!empty($data)) {
                    $this->setData($data);
                } else {
                    $this->id = null;
                }
            }
        }
    }

    private function getSelectTemplate()
    {
        return sprintf("SELECT * FROM `%s` WHERE `id`='%s'", $this::$fields_table, $this->id);
    }

    public function setData($data)
    {
        $this->name = $data['name'];
        $this->title = $data['title'];
        $this->example = $data['example'];
        $this->field = $data['field'];
        $this->editor = $data['editor'];
        $this->format = $data['format'];
        $this->multi = $data['multi'];
        $this->show = $data['show'];
        $this->required = $data['required'];
        $this->weight = $data['weight'];
        $this->options = $data['options'];
        $this->table = $data['table'];
        $this->sorter = $data['sorter'];
        $this->advanced = $data['advanced'];
        $this->main = $data['main'];
    }

    public function getData()
    {
        return array(
            "name" => $this->name,
            "title" => $this->title,
            "example" => $this->example,
            "field" => $this->field,
            "editor" => $this->editor,
            "format" => $this->format,
            "multi" => $this->multi,
            "show" => $this->show,
            "required" => $this->required,
            "weight" => $this->weight,
            "options" => $this->options,
            "table" => $this->table,
            "sorter" => $this->sorter,
            "advanced" => $this->advanced,
            "main" => $this->main
        );
    }

    protected static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function save()
    {
        $data = $this->getData();
        $db = Registry::get('db');
        if (!empty($this->id)) {
            $update = $db->sql->update();
            $update->table($this::$fields_table);
            $update->set($data);
            $update->where('id=' . $this->id);
            $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
        } else {
            $insert = $db->sql->insert();
            $insert->into($this->table);
            $insert->columns(array_keys($data));
            $insert->values($data);
            $db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
            $this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();
        }
    }
}
?>
