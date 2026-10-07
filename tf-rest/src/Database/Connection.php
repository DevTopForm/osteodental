<?php

namespace TFRest\Database;

use Exception;
use PDO;
use PDOException;

class Connection
{
    private static ?Connection $instance = null;
    private PDO $pdo;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        $host = "localhost";
        $dbname = 'ost7648855_tf';
        $username = 'ost7648855_tf';
        $password = '3QuM:dEy';

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw new Exception("Ошибка подключения к БД", 1);
        }
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}