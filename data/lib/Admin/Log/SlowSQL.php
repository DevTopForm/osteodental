<?php

namespace App\Admin\Log;

use App\Item\Log as ItemLog;
use App\Query;
use JsonException;

class SlowSQL extends Log
{
    protected static string $logFilePath = "/log/db_log.json";

    public function __construct(ItemLog $log)
    {
        parent::__construct($log);
    }

    public function setTemplateData(): void
    {
        $file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . static::$logFilePath);

        if ($file === false) {
            return;
        }

        $logs = json_decode($file, true);

        if (!$logs) {
            return;
        }

        usort($logs, function ($a, $b) {
            $sortField = Query::$get["sortField"] ?: "time";
            $sortOrder = Query::$get["sortOrder"] ?: "desc";

            if ($sortOrder === "asc") {
                return $a[$sortField] <=> $b[$sortField];
            } else {
                if ($a[$sortField] <= $b[$sortField]) {
                    return 1;
                } else {
                    return -1;
                }
            }
        });

        $this->tpl->assign('logs', $logs);
        $this->tpl->assign('item', $this);
    }

    public static function isActive(): bool
    {
        $log = new ItemLog(1);
        return $log->active;
    }

    public static function logSql($sql, $time): void
    {
        if (!static::isActive()) {
            return;
        }

        if (str_starts_with($_SERVER["REQUEST_URI"], "/adm")) {
            return;
        }

        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . static::$logFilePath)) {
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . static::$logFilePath, "{}");
        }

        // remove extra spaces
        $sql = preg_replace('/\s+/', ' ', $sql);
        $file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . static::$logFilePath);

        if ($file === false) {
            return;
        }

        try {
            $logs = json_decode($file, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return;
        }

        // массив ключей логов с таким же запросом
        $sameLogsKeys = empty($logs) ? [] : array_keys(array_column($logs, "sql"), $sql);
        if (count($sameLogsKeys)) {
            $sameLogKey = array_shift($sameLogsKeys);
            $sameLog = &$logs[$sameLogKey];

            $newCount = $sameLog["count"] ? $sameLog["count"] + 1 : 2;
            $sameLog["count"] = $newCount;
            $newAvgTime = (($newCount - 1) * (float)$sameLog["time"] + round($time, 2)) / $newCount;
            $sameLog["time"] = number_format($newAvgTime, 2, '.', '');
            unset($sameLog);
        } else {
            if ($time > 1.0) {
                $logs[] = [
                    "time" => number_format($time, 2, '.', ''),
                    "sql" => $sql,
                    "uri" => $_SERVER["REQUEST_URI"],
                    "date" => time()
                ];
            }
        }

        try {
            json_encode($logs, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return;
        }

        if (!empty($logs)) {
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . static::$logFilePath, json_encode($logs));
        }
    }

    public static function clear(): void
    {
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . static::$logFilePath, "{}");
    }
}