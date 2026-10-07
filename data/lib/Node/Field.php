<?php
namespace App\Node;

use App\Field as AppField;
use App\Form\Field as AppFormField;
use App\Node\Field\Complex;
use App\Registry;

class Field extends AppField
{

	protected static $fields_table = 'nodes_fields';
	protected static $option_table = 'nodes_fields_options';
	public $values;

	public function __construct($data = [])
	{
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$this->$key = $value;
			}
			$db = Registry::get('db');
			if (!empty($this->table_data)) {
				try {
					$whereString = "";
					if (!empty($this->table_filter)) {
						if (empty($this->table_value)) {
							$whereString = " AND $this->table_filter";
						} else {
							$whereString = sprintf(" AND `%s`='%s'", $this->table_filter, $this->table_value);
						}
					}
					$data = $db->query(
						sprintf(
							"
						SELECT `id`,`title`, `id` AS `value`
						FROM `%s`
						WHERE `public` = 1 %s
						ORDER BY `title` ASC
					",
							$this->table_data,
							$whereString
						),
						$db::QUERY_MODE_EXECUTE
					)->toArray();
					if (!empty($data)) {
						$this->options_data = $data;
					}
				} catch (\Exception $e) {
					die("Table $this->table_data does not exist");
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
						static::getVar('option_table'),
						$this->id
					),
					$db::QUERY_MODE_EXECUTE
				)->toArray();
				if (!empty($data)) {
					$this->options_data = $data;
				}
			}

			if ($this->field === "complex") {
				$subfields = Complex::getList(["filters" => ["fid = " . $this->id], "sorters" => ["weight ASC"]])->getItems();
				foreach ($subfields as &$subfield) {
					$subfield->node_field = new static($subfield);
				}
				unset($subfield);

				if ($subfields) {
					$this->subfields = array_combine(array_column($subfields, "id"), $subfields);
				}
			}

			$this->form_field = AppFormField::factory($this);
		}
	}

	function __clone()
	{
		$this->form_field = clone $this->form_field;
	}

	public static function getList($type)
	{
		$db = Registry::get('db');
		$data = $db->query(
			sprintf(
				"
			SELECT *
			FROM `%s`
			WHERE `type` = '%s'
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

	public static function getFieldByKey($type, $key)
	{
		$db = Registry::get('db');
		$data = $db->query(
			sprintf(
				"
			SELECT *
			FROM `%s`
			WHERE `type` = '%s'
			ORDER BY `weight` ASC
		",
				self::getVar('fields_table'),
				$type
			),
			$db::QUERY_MODE_EXECUTE
		)->toArray();

		$fields = [];
		$answer = 0;
		foreach ($data as $item) {
			if ($item['name'] == $key) {
				$answer = 1;
			}
		}
		return $answer;
	}

	protected static function getVar($name)
	{
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public static function getFilterList($type)
	{
		$db = Registry::get('db');
		$data = $db->query(
			sprintf(
				"
			SELECT *
			FROM `%s`
			WHERE `type` = '%s' AND `filter_show` = '%d'
			ORDER BY `weight` ASC
		",
				static::getVar('fields_table'),
				$type,
				1
			),
			$db::QUERY_MODE_EXECUTE
		)->toArray();
		$fields = [];

		foreach ($data as $item) {
			$item = new static($item);
			$fields[] = $item;
		}
		return $fields;
	}

	public function prepareValues()
	{
		$arrayItemsField = [];
		$values = [];
		$fieldName = $this->name;
		foreach ($this->items as $item) {
			if (!empty($item->$fieldName)) {
                if (in_array($this->field, ["multisel2area"])) {
                    if (!is_array($item->$fieldName)) {
                        $vals = explode(",", $item->$fieldName);
                    } else {
                        $vals = array_map(fn($item) => $item->id, $item->$fieldName);
                    }

                    $arrayItemsField = array_merge($arrayItemsField, $vals);
                } else {
                    $arrayItemsField[] = $item->$fieldName;
                }
			}
		}

        $arrayItemsField = array_unique($arrayItemsField);

		if (!empty($this->options_data)) {
			foreach ($this->options_data as $option) {
				if (array_search($option['id'], $arrayItemsField) !== false) {
					$values[] = $option;
				}
			}
		}

		return $values;
	}

	public function prepareMultipleValues()
	{
		$arrayItemsField = [];
		$values = [];
		$fieldName = $this->name;
		foreach ($this->items as $item) {
			if (!empty($item->$fieldName)) {
				$ids = explode(",", $item->$fieldName);
				$arrayItemsField = array_merge($arrayItemsField, $ids);
			}
		}

		if (!empty($this->options_data)) {
			foreach ($this->options_data as $option) {
				if (array_search($option['id'], $arrayItemsField) !== false) {
					$values[] = $option;
				}
			}
		}
		return $values;
	}

	public static function getProperty($type)
	{
		$db = Registry::get('db');
		$data = $db->query(
			sprintf(
				"
			SELECT *
			FROM `%s`
			WHERE `type` = '%s' AND `property` = 1
			ORDER BY `weight` ASC
		",
				static::getVar('fields_table'),
				$type
			),
			$db::QUERY_MODE_EXECUTE
		)->toArray();
		$fields = [];

		foreach ($data as $key => $item) {
			$field = new static($item);
			$fields[$field->name] = $field->title;
		}
		return $fields;
	}

	public static function getPropertyShow($type)
	{
		$db = Registry::get('db');
		$data = $db->query(
			sprintf(
				"
			SELECT *
			FROM `%s`
			WHERE `type` = '%s' AND `property_show` = 1
			ORDER BY `weight` ASC
		",
				static::getVar('fields_table'),
				$type
			),
			$db::QUERY_MODE_EXECUTE
		)->toArray();
		$fields = [];

		foreach ($data as $key => $item) {
			$field = new static($item);
			$fields[$field->name] = [
				'title' => $field->title,
				'field' => $field->field,
				'table' => $field->table_data,
				'value' => '',
			];
		}
		return $fields;
	}
}
