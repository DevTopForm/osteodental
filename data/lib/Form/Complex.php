<?php

namespace App\Form;

use App\Message;
use App\Query;
use App\Node\Field\Complex as ComplexItem;

class Complex extends Field
{
    protected $class = "complex";

    protected array $values = [];
    protected array $subfields = [];


    public function getInsertValue()
    {
        $values = [];

        foreach ($this->values as $row) {
            $emptyFieldsCount = 0;
            foreach ($row["fields"] as $field) {
                $fieldValue = $field->getValue();
                $values[$row["rowId"]][$field->id] = $fieldValue;

                if (in_array($field->field, ["image", "file", "checkbox"])) {
                    if (empty($fieldValue)) {
                        $emptyFieldsCount++;
                    }
                } else {
                    if ($fieldValue === "") {
                        $emptyFieldsCount++;
                    }
                }
            }

            if ($emptyFieldsCount === count($row["fields"])) {
                unset($values[$row["rowId"]]);
            }
        }

        return json_encode($values, JSON_UNESCAPED_UNICODE);
    }

    public function setValue($value, $id = null)
    {
        $values = json_decode($value, true);
        $preparedValues = [];
        // saved values may not consist of new fields, so need to get all
        $totalFields = ComplexItem::getList(["filters" => ["fid = " . $id], "sorters" => ["weight ASC"]])->getItems();

        if (!empty($values)) {
            foreach ($values as $rowId => $fields) {
                $preparedValues[$rowId] = ["rowId" => $rowId, "fields" => []];
                foreach ($totalFields as $requiredField) {
                    $preparedValues[$rowId]["fields"][$requiredField->id] = clone $requiredField->node_field;

                    if ($fields[$requiredField->id]) {
                        $preparedValues[$rowId]["fields"][$requiredField->id]->setValue($fields[$requiredField->id]);
                    }
                }
            }

            $this->values = $this->sortRows($preparedValues, $totalFields);
        }
    }

    protected function sortRows($rows, $fields = []): array
    {
        $sorterFieldId = null;

        if ($fields) {
            $sorterFieldId = static::getSorterFieldId($fields);
        }

        if ($sorterFieldId) {
            uasort($rows, function ($a, $b) use ($sorterFieldId) {
                return $a["fields"][$sorterFieldId]->getValue() <=> $b["fields"][$sorterFieldId]->getValue();
            });
        }

        return $rows;
    }

    protected static function getSorterFieldId($fields): null|int
    {
        foreach ($fields as $field) {
            if ($field->sorter) {
                return $field->id;
            }
        }

        return null;
    }

    protected static function getSorterFieldName($fields): null|string
    {
        foreach ($fields as $field) {
            if ($field->sorter) {
                return $field->name;
            }
        }

        return null;
    }

    public function getSpecValue()
    {
        return $this->values;
    }

    public function setQueryValue()
    {
        $values = [];

        if (!empty(Query::$post[$this->name])) {
            foreach (Query::$post[$this->name] as $rowId => $fields) {
                $deleteRowIds = Query::$post[$this->name . "_delete"];
                if (is_array($deleteRowIds) && in_array($rowId, $deleteRowIds)) {
                    continue;
                }

                if (empty(array_filter($fields))) {
                    continue;
                }

                if (!empty($fields)) {
                    $values[$rowId] = ["rowId" => $rowId, "fields" => []];

                    foreach ($this->subfields as $subfield) {
                        $values[$rowId]["fields"][$subfield->id] = clone $subfield->node_field;
                        $values[$rowId]["fields"][$subfield->id]->setValue($fields[$subfield->id] ?: null);
                    }
                }
            }
        }

        if (!empty(Query::$files[$this->name])) {
            foreach (Query::$files[$this->name] as $rowId => $fields) {
                $deleteRowIds = Query::$post[$this->name . "_delete"];
                if (is_array($deleteRowIds) && in_array($rowId, $deleteRowIds)) {
                    continue;
                }

                if (empty(array_filter($fields))) {
                    continue;
                }

                if (!empty($fields)) {
                    $values[$rowId] = ["rowId" => $rowId, "fields" => []];

                    foreach ($this->subfields as $subfield) {
                        // if field has already set (from db), save the same value, else create new field for file
                        $values[$rowId]["fields"][$subfield->id] = ($this->values[$rowId]["fields"][$subfield->id]) ?: clone $subfield->node_field;
                    }
                }
            }
        }

        $this->values = $values;
    }

    public function validate($subfields = [])
    {
        $this->subfields = $subfields;
        $this->messages = [];
        $this->setQueryValue();

        if (!empty($this->required) && empty($this->values)) {
            $this->messages[] = new Message(
                '{$_LNG_ADM.REQUIRED_FIELD} «' . $this->title . '» {$_LNG_ADM.IS_EMPTY}',
                'error'
            );
        }

        foreach ($this->values ?: [] as $rowId => $row) {
            foreach ($row["fields"] as $fieldId => $field) {
                $field->setComplexFieldProperties($this->name, $rowId, $fieldId);
                $msgs = $field->validate();
                if ($msgs) {
                    $field->errorsMessage = implode('<br>', array_column($field->getMessages(), 'html'));
                }
                $this->values[$rowId]["fields"][$fieldId] = $field;
                if ($msgs) {
                    $this->messages = array_merge($this->messages, $msgs);
                }
            }
        }

        return $this->messages;
    }

    public static function getDisplayValue($value): array
    {
        $values = json_decode($value, true);
        $preparedValues = [];
        $totalFields = [];

        if (!empty($values)) {
            foreach ($values as $rowId => $fields) {
                $preparedValues[$rowId] = ["id" => $rowId];
                foreach ($fields as $fieldId => $value) {
                    if (empty($totalFields[$fieldId])) {
                        $field = new ComplexItem($fieldId);
                        if ($field->id) {
                            $totalFields[$field->id] = $field;
                        }
                    }

                    $fieldName = $totalFields[$fieldId]?->name;

                    if ($fieldName) {
                        $preparedValues[$rowId][$fieldName] = match ($totalFields[$fieldId]->field) {
                            "file" => new \App\File($value),
                            "image" => new \App\Image($value),
                            default => $value,
                        };
                    }
                }
            }

            if ($totalFields) {
                $sorterFieldName = static::getSorterFieldName($totalFields);
            }

            uasort($preparedValues, function ($a, $b) use ($sorterFieldName) {
                return $a[$sorterFieldName] <=> $b[$sorterFieldName];
            });
        }

        return $preparedValues;
    }

    public function prepareValue($value)
    {
        return $value;
    }
}
