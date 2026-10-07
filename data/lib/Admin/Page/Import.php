<?php

namespace App\Admin\Page;

use App\Cabinet\Exception;
use App\Item\History as ItemHistory;
use App\Node\Field;
use App\Params;
use App\Query;
use App\Registry;
use App\Structure;
use App\Utils;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Node\Type;
use App\Node\Catalog\Field\Item as CatalogFieldItem;

class Import extends LAVED
{
    protected string $localFilePath = "";
    protected string $logFilePath = "";
    protected string $imagesDirPath = "";
    protected array $log = [];
    protected $localTpl = 'content/import.tpl';
    protected $action = 'import';

    private $db;

    protected $defaultState = self::STATE_EDIT;

    public array $messages = [
        'error' => [],
        'info' => [
            'updated' => 0,
            'inserted' => 0,
        ],
        'time' => 0
    ];

    /**
     * @throws \Smarty\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function parseStateEdit()
    {
        ItemHistory::add("Импорт", "/adm/import");

        $tpl = $this->getItemsTpl();
        $tables = Type::getList(["filters" => ["has_items = 1"]])->getItems();
        $tpl->assign('tables', $tables);

        if (!empty(Query::$get["table"])) {
            $type = new Type(Query::$get["table"]);
            $nodes = \App\Node::getList(["filters" => ["type = '$type->type'"]])->getItems();
            $tpl->assign('type', $type->type);
            $tpl->assign('nodes', Structure::get_instance()->get_tree());
        }

        if (!empty(Query::$post['send']) && !empty($_FILES['file'])) {
            $this->initImport();
            if ($this->openFile()) {
                $this->processLog('Файл загружен', 0);

                $columns = $this->getTableColumns();
                $tpl->assign('columns', $columns);

                $fields = $this->getModuleFields();
                $tpl->assign('fields', $fields);

                $type = new Type(Query::$get["table"]);
                if ($type->is_catalog) {
                    $props = $this->getModuleProps();
                    $tpl->assign('props', $props);

                    $fieldTypes = $this->getFieldTypes();
                    $tpl->assign('fieldTypes', $fieldTypes);
                }

                $matches = $this->getColumnsAndFieldsMatches($columns, $fields, $props ?? []);
                $tpl->assign('matches', $matches);
            }
        }

        if (!empty(Query::$post['step']) && Query::$post['step'] === "import") {
            $this->initImport();

            if ($this->openFile()) {
                if ($this->validateOptions()) {
                    $this->processLog('Файл загружен', 0);
                    $this->loadImportData();
                }
            }

            echo json_encode($this->messages);
            die();
        }

        $this->messages['time'] = round(microtime(1) - $this->messages['time'], 4);
        $tpl->assign('messages', $this->messages);

        return $tpl->fetch($this->localTpl);
    }

    /**
     * @param $columns
     * @param $fields
     * @param $props
     * @return array|array[]
     *
     * Сопоставляет столбцы таблицы с полями и свойствами элемента по названию
     */
    protected function getColumnsAndFieldsMatches($columns, $fields, $props = []): array
    {
        $matches = [
            "fields" => [],
            "props" => []
        ];

        foreach ($columns as $columnKey => $columnTitle) {
            foreach ($fields as $field) {
                if ($field->title === $columnTitle) {
                    $matches["fields"][$columnKey] = $field->id;
                }
            }

            foreach ($props as $prop) {
                if ($prop->title === $columnTitle) {
                    $matches["props"][$columnKey] = $prop->id;
                }
            }
        }

        return $matches;
    }


    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function validateOptions(): bool
    {
        $errCount = count($this->messages['error']);

        /**
         * Модуль импорта указывается всегда. Если не указан раздел, то должен быть указан ключ элемента.
         * Если раздел указан, наличие или отсутствие ключей раздела и элемента может быть вариативным
         */

        if (empty(Query::$post["table"])) {
            $this->messages['error'][] = "Не указан модуль";
        }

        $itemKey = null;

        $columns = $this->getTableColumns();
        foreach ($columns as $key => $title) {
            if (!empty(Query::$post["item_keys"][$key])) {
                $itemKey = $key;
            }

            // Если столбец связан с полем, то валидировать нечего, иначе проверка свойства
            if (empty(Query::$post["fields"][$key])) {
                // Если столбец связан с существующим свойством, то валидировать нечего, иначе проверка свойства
                $type = new Type(Query::$post["table"]);
                if ($type->is_catalog) {
                    if (empty(Query::$post["props"][$key])) {
                        if (empty(Query::$post["types"][$key])) {
                            $this->messages['error'][] = "Для столбца \"$title\" не указан тип нового свойства";
                        } elseif (in_array(Query::$post["types"][$key], ["select", "multiselect", "multisel2area"])) {
                            if (empty(Query::$post["tables"][$key])) {
                                $this->messages['error'][] = "Для столбца \"$title\" не указана таблица для списка";
                            }
                            if (empty(Query::$post["nodes"][$key])) {
                                $this->messages['error'][] = "Для столбца \"$title\" не указан раздел с элементами для списка";
                            }
                        }
                    }
                } else {
                    // Поле не заполнено, не каталог, не ключ раздела - ошибка
                    if (empty(Query::$post["section_keys"][$key])) {
                        $this->messages['error'][] = "Для столбца \"$title\" не указано соответствующее поле";
                    }
                }
            }
        }

        if (empty(Query::$post["node_id"]) && $itemKey === null) {
            $this->messages['error'][] = "Если не указан раздел для импорта, то должно быть хотя бы одно свойство, 
            являющееся ключом элемента.";
        }

        return count($this->messages['error']) - $errCount <= 0;
    }

    protected function getFieldTypes(): array
    {
        return [
            'text' => "Строка",
            'textarea' => "Текст",
            'checkbox' => "Флажок",
            'integer' => "Число (целое)",
            'multiselect' => "Множественный выбор из списка",
            'multisel2area' => "Множественный выбор из списка в область",
            'select' => "Выбор из списка",
            'alias' => "ЧПУ",
        ];
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getTableColumns(): array
    {
        $objPHPExcel = IOFactory::load($this->localFilePath);
        $excelObject = $objPHPExcel->getSheet(0);
        $highestColumn = $excelObject->getHighestColumn();

        $rowData = $excelObject->rangeToArray('A1:' . $highestColumn . 1, null, true, false);
        return $rowData[0];
    }

    protected function getModuleProps(): array
    {
        $fieldItem = new CatalogFieldItem();
        return $fieldItem->list($this->getParameters())->getItems();
    }

    protected function getModuleFields(): array
    {
        $type = new Type(Query::$get["table"]);
        return Field::getList($type->type);
    }

    /**
     * Запись в лог-файл
     *
     * @param $text
     * @param $key
     */
    protected function processLog($text, $key): void
    {
        $this->log[$key] = $text;
        file_put_contents($this->logFilePath, implode('<br/>', $this->log));
    }

    /**
     * Старт загрузки
     */
    protected function initImport(): void
    {
        $this->db = Registry::get('db');
        $this->messages['time'] = microtime(1);
        $this->imagesDirPath = Params::$params['root_path'] . 'import_images/';
        $this->logFilePath = Params::$params['root_path'] . 'upload/import_process.txt';

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 3000);
        ini_set('mbstring.func_overload', 0);
        mb_internal_encoding('UTF-8');
    }

    /**
     * Загрузка и сохранение файла
     *
     * @return bool
     */
    protected function openFile(): bool
    {
        if (empty(Query::$files['file']['tmp_name']) || Query::$files['file']['error'] != 0) {
            $this->messages['error'][] = "Не выбран файл";
            return false;
        }

        $ext = explode('.', Query::$files['file']['name']);
        if (!in_array(array_pop($ext), ['xlsx', 'xls'])) {
            $this->messages['error'][] = "Допускаются только форматы xls и xlsx";
            return false;
        }

        $this->localFilePath = Params::$params['root_path'] . 'upload/' . Query::$files['file']['name'];
        if (!@move_uploaded_file(Query::$files['file']['tmp_name'], $this->localFilePath)) {
            $this->messages['error'][] = "Невозможно переместить файл. Директория '" . $this->localFilePath . "' защищена от записи";
            return false;
        }

        if (!file_exists($this->localFilePath)) {
            $this->messages['error'][] = "Файл не перемещен.";
            return false;
        }

        return true;
    }

    /**
     * Чтение файла и импорт
     *
     * @return bool
     */
    protected function loadImportData(): bool
    {
        try {
            $objPHPExcel = IOFactory::load($this->localFilePath);

            $sheet = $objPHPExcel->getSheet(0);
            $highestColumn = $sheet->getHighestColumn();

            /*
             * Импорт цен (остатков) может быть без указания раздела. В нём только модуль и привязка к товару по
             * какому-либо из столбцов, остальные столбцы - сами цены (остатки)
             *
             * Импорт товаров - только с указанием раздела. Если галочка для столбцов "ключ раздела" не стоит,
             * то все товары в указанный раздел, иначе поиск в этом разделе раздела по ключу - если нашёлся,
             * то товар в него, иначе создаётся новый раздел
             *
             * Ключ элемента может быть как указан для существующего свойства или поля - тогда поиск элемента по этому
             * свойству (название, артикул), так и не указан - тогда все элементы будут считаться новыми. Для нового
             * свойства ключ тоже может быть указан, но в этом нет никакого смысла - товар не будет найден.
             *
             * В итоге:
             * При импорте цен нет разделов в таблице и не указывается раздел для импорта, но обязательно присутствует
             * ключ элемента. Элемент ищется во всём модуле и обновляется, если такой есть.
             * При импорте элементов обязательно указывается раздел для импорта, а ключ для раздела может как быть
             * указан, так и нет, тогда элементы либо ищутся в указанном разделе, либо с учётом ключа раздела в
             * указанном разделе соответственно. При этом ключ у элементов может быть, как указан, так и нет
             *
             * Т.Е.:
             * Модуль импорта указывается всегда. Если не указан раздел, то должен быть указан ключ элемента.
             * Если раздел указан, наличие или отсутствие ключей раздела и элемента может быть вариативным
             */

            $i = 0;
            $columns = $this->prepareImportColumns();
            $itemKey = $this->getItemOrSectionKey($columns);
            $nodeKey = $this->getItemOrSectionKey($columns, true);

            for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                /*
                 * Фильтр по разделам добавляется, только если указан раздел импорта, а ключ раздела для уточнения, может
                 * как быть, так и нет
                 */
                $item = [
                    "fields" => [],
                    "props" => [],
                    "node" => Query::$post["node_id"] ?: null,
                ];

                $nodeId = $this->getItemNode($nodeKey, $rowData[0]);
                if ($nodeId) {
                    $item["node"] = $nodeId;
                }

                foreach ($rowData[0] as $columnId => $importValue) {
                    // Пропускаем столбец с ключом раздела, т.к. это не свойство элемента
                    if ($columnId !== $nodeKey) {
                        if (isset($columns[$columnId])) {
                            $column = $columns[$columnId];
                            $item[$column["type"]][$column["key"]] = $importValue;
                        }
                    }
                }

                $table = 'content_' . (new Type(Query::$post["table"]))->type;

                $itemId = $this->getItemId($itemKey, $rowData[0], $columns, $item['node'], $table);
                $this->saveItem($item, $itemId, $table);

                $i++;
                if ($i % 50 == 0) {
                    $this->processLog('Импортировано ' . $i . ' из ' . $sheet->getHighestRow() - 1 . ' элементов', 2);
                }
            }

            $this->processLog('Импортировано ' . $i . ' из ' . $sheet->getHighestRow() - 1 . ' элементов', 2);

            return true;
        } catch (\Exception $e) {
            $this->messages['error'][] = $e->getMessage();
            return false;
        }
    }


    /**
     * @param array $item
     * @param int $itemId
     * @param string $table
     * @return void
     *
     * Обновляет или создаёт элемент
     */
    protected function saveItem(array $item, int $itemId, string $table): void
    {
        $fields = $item["fields"];

        if (!empty($item["props"])) {
            $fields["properties"] = json_encode($item["props"]);
        }

        if ($itemId) {
            // Обновление существующего элемента
            $query = $this->db->sql->update();
            $query->where(sprintf('id = "%s"', $itemId));
            $query->table($table);
            $query->set($fields);
            $this->db->query($this->db->sql->buildSqlString($query), $this->db::QUERY_MODE_EXECUTE);
            $this->messages['info']['updated']++;
        } else {
            // Добавление нового элемента
            $fields["public"] = 1;
            if (!empty($item["node"])) {
                $fields["node"] = $item["node"];
            }

            $query = $this->db->sql->insert();
            $query->into($table);
            $query->values($fields);
            $this->db->query($this->db->sql->buildSqlString($query), $this->db::QUERY_MODE_EXECUTE);
            $this->messages['info']['inserted']++;
        }
    }


    /**
     * @param int|false $itemKey
     * @param array $rowData
     * @param array $columns
     * @param int|null $node
     * @param string $table
     * @return int
     *
     * Поиск элемента по ключевому полю и разделу
     */
    protected function getItemId(int|false $itemKey, array $rowData, array $columns, int|null $node, string $table): int
    {
        // Подготовка ключа элемента
        $itemKeyField = "";

        if ($itemKey !== false) {
            $itemKeyField = $columns[$itemKey]["key"];
        }

        if ($itemKeyField) {
            $filtersArray = [];
            $itemKeyValue = $rowData[$itemKey];
            $itemKeyType = $columns[$itemKey]["type"];
            if ($itemKeyType === "fields") {
                $filtersArray[] = "`$itemKeyField` = '$itemKeyValue'";
            } else {
                $filtersArray[] = "properties->>'$." . $itemKeyField . "' = '" . $itemKeyValue . "'";
            }

            if ($node) {
                $filtersArray[] = "`node` = " . $node;
            }

            $itemIds = $this->db->query(
                sprintf('SELECT `id` FROM %s WHERE %s', $table, implode(" AND ", $filtersArray)),
                $this->db::QUERY_MODE_EXECUTE
            )->toArray();

            return $itemIds[0]["id"] ?: 0;
        }

        return 0;
    }


    /**
     * Определение/создание раздела, только если указан ключ раздела и раздел импорта
     * Раздел импорта может быть не указан для импорта цен, тогда и фильтр по разделу для поиска товара
     * не нужен
     */
    protected function getItemNode($nodeKey, $rowData): int
    {
        if ($nodeKey !== false && Query::$post["node_id"]) {
            $nodeTitle = $rowData[$nodeKey];

            if ($nodeTitle) {
                $node = $this->db->query(
                    sprintf(
                        'SELECT `id` FROM %s WHERE (`parent`=%s AND `title`="%s")',
                        'nodes',
                        Query::$post['node_id'],
                        $nodeTitle,
                    ),
                    $this->db::QUERY_MODE_EXECUTE
                )->toArray();
                if (empty($node)) {
                    $query = $this->db->sql->insert();
                    $query->into('nodes');
                    $query->values([
                            "alias" => $this->generateAlias($nodeTitle, Query::$post['node_id']),
                            "type" => (new Type(Query::$post["table"]))->type,
                            "parent" => Query::$post['node_id'],
                            "title" => $nodeTitle,
                            'menutitle' => $nodeTitle,
                            "content_template" => (new \App\Node(Query::$post['node_id']))->content_template->id,
                            "template" => 2,
                            "public" => 1,
                            "sitemap" => 0
                        ]
                    );
                    $this->db->query($this->db->sql->buildSqlString($query), $this->db::QUERY_MODE_EXECUTE);
                    return $this->db->getDriver()->getConnection()->getLastGeneratedValue();
                } else {
                    return $node[0]['id'];
                }
            }
        }

        return 0;
    }


    protected function getItemOrSectionKey(array $columns, bool $isSectionKey = false): false|int|string
    {
        $keyTitle = $isSectionKey ? "is_section_key" : "is_item_key";
        foreach ($columns as $columnKey => $column) {
            if ($column[$keyTitle]) {
                return $columnKey;
            }
        }

        return false;
    }


    /**
     * Метод формирует массив свойств, выбранных при импорте, и создаёт их при необходимости
     * @throws Exception
     */
    protected function prepareImportColumns(): array
    {
        try {
            $tableColumns = $this->getTableColumns();
            $columns = [];
            if (!empty(Query::$post["fields"])) {
                foreach (Query::$post["fields"] as $i => $fieldId) {
                    // Если для столбца задано поле, то оно в приоритете перед свойством
                    if (!empty($fieldId)) {
                        $field = new Field\Item($fieldId);

                        if (empty($field->id)) {
                            $errorText = "Для столбца №" . $i . " не найдено соответствующее поле";
                            throw new Exception($errorText);
                        } else {
                            $columns[$i]["key"] = $field->name;
                            $columns[$i]["type"] = "fields";
                        }
                    } else {
                        if (!empty(Query::$post["props"][$i])) {
                            $field = new CatalogFieldItem(Query::$post["props"][$i]);

                            if (empty($field->id)) {
                                $errorText = "Для столбца №" . $i . " не найдено соответствующее свойство";
                                throw new Exception($errorText);
                            } else {
                                $columns[$i]["key"] = $field->name;
                                $columns[$i]["type"] = "props";
                            }
                        } elseif (empty(Query::$post["section_keys"][$i])) {
                            $propModule = null;
                            $propNode = null;

                            $propType = Query::$post["types"][$i];
                            if (in_array($propType, ["select", "multiselect", "multisel2area"])) {
                                $propModule = new Type(Query::$post["tables"][$i]);
                                $propNode = Query::$post["nodes"][$i];
                            }

                            $prop = $this->createProperty(
                                $propType,
                                $tableColumns[$i],
                                $propModule->type ?? null,
                                $propNode ?? null
                            );

                            if (empty($prop->id)) {
                                $errorText = "Для столбца №" . $i . " не удалось создать свойство";
                                throw new Exception($errorText);
                            } else {
                                $columns[$i]["key"] = $prop->name;
                                $columns[$i]["type"] = "props";
                            }
                        }
                    }

                    if (!empty(Query::$post["section_keys"][$i])) {
                        $columns[$i]["is_section_key"] = true;
                    }
                    if (!empty(Query::$post["item_keys"][$i])) {
                        $columns[$i]["is_item_key"] = true;
                    }
                }
            }
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }

        return $columns;
    }


    /**
     * @param string $propType
     * @param string $propTitle
     * @param $propSelectModule
     * @param $propSelectNode
     * @return CatalogFieldItem
     *
     * Создание нового свойства каталога
     */
    protected function createProperty(
        string $propType,
        string $propTitle,
               $propSelectModule = null,
               $propSelectNode = null
    ): CatalogFieldItem {
        $field = new CatalogFieldItem();
        $field->type = "catalog";
        $field->name = Utils::translit($propTitle);
        $field->title = $propTitle;
        $field->field = $propType;
        $field->property_show = 0;
        $field->property_list_show = 0;
        $field->property_list_show_mobile = 0;
        $field->table_data = $propSelectModule ? "content_$propSelectModule" : "";
        $field->table_filter = $propSelectNode ? "node" : "";
        $field->table_value = $propSelectNode ?: "";
        $field->save();

        return $field;
    }


    protected function aliasExists($alias, $parent): bool
    {
        $item = $this->db->query(
            sprintf(
                'SELECT `id` FROM %s WHERE (`parent`=%s AND `alias`="%s")',
                'nodes',
                Query::$post['node_id'],
                $alias
            ),
            $this->db::QUERY_MODE_EXECUTE
        )->toArray();
        return !empty($item);
    }

    protected function generateAlias($title, $parent): array|string|null
    {
        $alias = Utils::translit($title);
        $prefix = 0;
        while ($this->aliasExists($alias, $parent)) {
            $alias = sprintf('%s_%s', $alias, ++$prefix);
        }
        return $alias;
    }
}