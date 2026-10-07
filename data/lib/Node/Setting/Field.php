<?php

namespace App\Node\Setting;

use App\Field as AppField;
use App\Form\Field as FormField;
use App\Node\Field as NodeField;
use App\Params;
use App\Registry;


class Field extends AppField
{

    protected static $fields_table = 'nodes_params_fields';
    protected static $option_table = 'nodes_params_fields_options';

    public function __construct($data = array())
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            $db = Registry::get('db');
            if (!empty($this->table_data)) {
                try {
                    if (!empty($this->table_filter)) {
                        $filters = unserialize($this->table_filter);
                        $this->table_filter = $filters[0]['field'] ?? '';
                        $this->table_value = $filters[0]['value'] ?? '';
                    } else {
                        $filters = array();
                    }
                    $filterSql = array();
                    foreach ($filters as $filter) {
                        $filterSql[] = sprintf('`%s`%s"%s"', $filter['field'], $filter['operation'], $filter['value']);
                    }
                    $data = $db->query(
                        sprintf(
                            "
						SELECT `id`,`title`,`id` AS `value`
						FROM `%s`
						WHERE %s
						ORDER BY `title` ASC
					",
                            $this->table_data,
                            empty($filterSql) ? '1' : join(' AND ', $filterSql)
                        ),
                        []
                    )->toArray();
                    if (!empty($data)) {
                        $this->options_data = $data;
                    }
                } catch (\Exception $e) {
                    die($e->getMessage());
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
                    []
                )->toArray();

                if (!empty($data)) {
                    $this->options_data = $data;
                }
            }
            if (empty(Params::$params['advanced']) && !empty($this->advanced)) {
                $this->type = 'hidden';
            }
            $this->form_field = FormField::factory($this);
        }
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
                self::getVar('fields_table'),
                $type
            ),
            []
        )->toArray();
        $fields = array();

        foreach ($data as $item) {
            $fields[] = new NodeField($item);
        }
        return $fields;
    }

    protected static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }
}

?>
