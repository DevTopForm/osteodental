<?php

namespace App;


use App\Admin\Log\SlowSQL;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use Laminas\Db\ResultSet;
use Laminas\Db\Adapter\Platform;
use Laminas\Db\Adapter\Profiler;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;

class Db extends Adapter
{
    public function __construct(
        $driver,
        Platform $platform = null,
        ResultSet\ResultSetInterface $queryResultPrototype = null,
        Profiler $profiler = null
    ) {
        parent::__construct($driver, $platform, $queryResultPrototype, $profiler);
        $this->sql = new Sql($this);
        $this->query("SET time_zone = '+3:00'");
    }

    public function query(
        $sql,
        $parametersOrQueryMode = self::QUERY_MODE_PREPARE,
        ResultSet\ResultSetInterface $resultPrototype = null
    ) {
        if (!is_dir('log')) {
            mkdir('log');
        }
        if (preg_match('/UPDATE|INSERT|DROP|DELETE|CREATE|ALTER/i', $sql)) {
            $logger = new Logger();
            $writer = new Stream('log/db_change.log');
            $logger->addWriter($writer);
            $logger->info($sql);
        }

        $msc = microtime(true);
        $result = parent::query($sql, $parametersOrQueryMode, $resultPrototype);
        $msc = (microtime(true) - $msc) * 1000;

        // исключаем самый первый запрос, когда база ещё не добавлена в регистр,
        // и рекурсивный запрос на проверку активности логирования
        if (!in_array($sql, ["SET time_zone = '+3:00'", "SELECT * FROM `logs` WHERE id=1"])) {
            SlowSQL::logSql($sql, $msc);
        }

        return $result;
    }
}
