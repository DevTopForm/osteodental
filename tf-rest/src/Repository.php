<?php

namespace TFRest;

use PDO;
use TFRest\Database\Connection;

abstract class Repository
{
    protected PDO $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = Connection::getInstance()->getPdo();
    }

    public function getList(array $filters = [], array $sorters = [], $limit = 10): false|array|null
    {
        $filters = $this->prepareFilters($filters);
        $sorters = $this->prepareSorters($sorters);
        $stmt = $this->pdo->prepare(
            "SELECT * FROM $this->table WHERE " . ($filters ?: 1) . " ORDER BY " . ($sorters ?: "id ASC") . ($limit ? " LIMIT $limit" : "")
        );
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    public function getByKey(string $key, string|int $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE $key = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetch() ?: null;
    }

    private function prepareFilters(array $filters): string
    {
        return implode(" AND ", $filters);
    }

    private function prepareSorters(array $sorters): string
    {
        return implode(", ", $sorters);
    }
}