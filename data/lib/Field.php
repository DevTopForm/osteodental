<?php

namespace App;

use App\Form\Field as FormField;


class Field
{

    protected static $fields_table = 'fields';
    protected static $option_table = 'fields_options';

    public $id;
    public $name;
    public $node_type;
    public $type;
    public $title;
    public $editor;
    public $format;
    public $multi;
    public $show;
    public $required;
    public $weight;
    public $options;
    public $table;
    public $sorter;
    public $default;
    public $options_data = [];
    public $subfields = [];
    protected $form_field = null;
    public $value;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            if (empty(Params::$params['advanced']) && !empty($this->advanced)) {
                $this->type = 'hidden';
            }
            if (is_object($this->field)) {
                $this->field = $this->field->field;
            }
            $this->form_field = FormField::factory($this);
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
                            ),
                            $db::QUERY_MODE_EXECUTE
                        )->toArray();
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
                        ),
                        $db::QUERY_MODE_EXECUTE
                    )->toArray();


                    if (!empty($data)) {
                        $this->options_data = $data;
                    }
                }
            }
        }
    }

    public function setComplexFieldProperties(string $title, int $rowId, int $propId)
    {
        $this->form_field->setComplexFieldProperties($title, $rowId, $propId);
    }

    public function setParams($params = [])
    {
        $this->form_field->setParams($params);
    }

    public function getHtml($name = "")
    {
        return $this->form_field->getHtml($this->id, $name);
    }

    public function getSpecialHtml()
    {
        return $this->form_field->getSpecialHtml();
    }

    public function setValue($value, $id = null)
    {
        $this->form_field->setValue($value, $this->id);
    }

    public function setItem($item)
    {
        $this->form_field->setItem($item);
    }

    public function setName($name)
    {
        $this->form_field->setName($name);
    }

    public function getName()
    {
        return $this->form_field->getName();
    }

    public function getValue()
    {
        return $this->form_field->getInsertValue();
    }

    public function setVariant()
    {
        return $this->form_field->setVariant();
    }

    public function getSpecValue()
    {
        return $this->form_field->getSpecValue();
    }

    public function getAttach()
    {
        return $this->form_field->getAttach();
    }

    public function getTypeField()
    {
        return $this->form_field->getTypeField();
    }

    public function prepareValue($value)
    {
        return $this->form_field->prepareValue($value);
    }

    public function validate()
    {
        return $this->form_field->validate($this->subfields ?: []);
    }

    public function removeAttach()
    {
        $this->form_field->removeAttach();
    }

    public function setQueryValue()
    {
        return $this->form_field->setQueryValue();
    }

    public function getMessages()
    {
        return $this->form_field->getMessages();
    }

    public static function getList($type)
    {
        $db = Registry::get('db');
        $data = $db->query(
            sprintf(
                "
			SELECT *
			FROM `%s`
			WHERE `node_type` = '%s'
			ORDER BY `weight` ASC
		",
                static::getVar('fields_table'),
                $type
            ),
            $db::QUERY_MODE_EXECUTE
        )->toArray();
        $fields = [];

        foreach ($data as $item) {
            $fields[] = new static($item);
        }
        return $fields;
    }

    protected static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }
}
