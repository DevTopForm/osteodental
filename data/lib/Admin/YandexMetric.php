<?php

// API class for processing Yandex Metric data

namespace App\Admin;

use Exception;

class YandexMetric
{
    const API_DOMAIN = "https://api-metrika.yandex.net";
    const QUERY_PARAMS = [
        "sources_comparison" => [
            'id' => 'sources_comparison',
            'uri' => '/stat/v1/data/comparison',
            'title' => 'Трафик по источникам за отчетный период',
            'dimensions' => 'ym:s:CROSS_DEVICE_LAST_SIGNIFICANTTrafficSource',
            'group' => 'all',
            'metrics' => 'ym:s:users,ym:s:visits',
            'special' => '2monthsCompare',
            'prepareData' => 'prepareCompareInfo',
            'filters' => "ym:s:isRobot=='No'",
        ],
    ];


    /**
     * @throws Exception
     */
    static function prepareParams(string $queryKey, array $argParams): array
    {
        $queryParams = self::QUERY_PARAMS[$queryKey];
        $counterId = $argParams["counterId"];
        $fromDate = $argParams["from"];
        $tillDate = $argParams["till"];

        if (empty($counterId) || empty($fromDate) || empty($tillDate)) {
            throw new Exception("В запрос не переданы даты или id счётчика", 0);
        }

        $params = [
            'ids' => $counterId,
            'uri' => $queryParams["uri"] ?: "/stat/v1/data",
            'date1' => date('Y-m-d', $fromDate),
            'date2' => date('Y-m-d', $tillDate),
            'lang' => 'ru'
        ];

        if (!empty($queryParams['metrics'])) {
            $params['metrics'] = $queryParams['metrics'];
        }

        if (!empty($queryParams['dimensions'])) {
            $params['dimensions'] = $queryParams['dimensions'];
        }

        if (!empty($queryParams['sort'])) {
            $params['sort'] = $queryParams['sort'];
        }

        if (!empty($queryParams['limit'])) {
            $params['limit'] = $queryParams['limit'];
        }

        if (!empty($queryParams['filters'])) {
            $params['filters'] = $queryParams['filters'];
        }

        if (!empty($queryParams['group'])) {
            $params['group'] = $queryParams['group'];
        }

        if (!empty($queryParams['include_undefined'])) {
            $params['include_undefined'] = $queryParams['include_undefined'];
        }


        if (!empty($queryParams['special'])) {
            switch ($queryParams['special']) {
                case '2monthsCompare':
                    unset($params['date1']);
                    unset($params['date2']);

                    $params['date1_a'] = date('Y-m-d', $fromDate);
                    $params['date2_a'] = date('Y-m-d', $tillDate);

                    $dateDiff = $tillDate - $fromDate;
                    $params['date1_b'] = date('Y-m-d', $fromDate - 60 * 60 * 24 - $dateDiff);
                    $params['date2_b'] = date('Y-m-d', $fromDate - 60 * 60 * 24);
                    break;

                default:
            }
        }

        return $params;
    }

    /**
     * @throws Exception
     */
    static function doRequest(array $params, string $token)
    {
        $headers = [
            'Content-Type: application/x-yametrika+json',
            'Authorization: ' . sprintf('OAuth %s', $token)
        ];

        $url = self::API_DOMAIN . $params["uri"];
        unset($params["uri"]);
        $url .= '?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("Ошибка запроса к API Яндекс Метрики", 0);
        }

        curl_close($ch);
        return json_decode($response);
    }

    static function prepareComparisonDataForMetrics($metrics, $currentVal, $prevVal): array
    {
        $result = [];

        foreach ($metrics as $metricId => $metric) {
            $metricData = [];
            $metricData["current"] = $currentVal[$metricId];
            $metricData["previous"] = $prevVal[$metricId];
            $metricData["type"] = $metric["type"];

            if (!empty($metric["reversed"])) {
                $metricData["reversed"] = $metric["reversed"];
            }

            $result[$metric["title"]] = $metricData;
        }

        return $result;
    }

    static function formatReceivedResponse($result, $data, $metrics): array
    {
        if (!empty($data->data) && is_array($data->data)) {
            foreach ($data->data as $dimensionObj) {
                if (!empty($dimensionObj->dimensions[0]->name) && !empty($dimensionObj->metrics)) {
                    $result["data"]["items"][$dimensionObj->dimensions[0]->id] = static::prepareComparisonDataForMetrics(
                        $metrics,
                        $dimensionObj->metrics->a,
                        $dimensionObj->metrics->b
                    );
                }
            }
        }

        if ($data->totals) {
            $result["data"]["total"] = static::prepareComparisonDataForMetrics(
                $metrics,
                $data->totals->a,
                $data->totals->b
            );
        }

        $result["data"]["metrics"] = $metrics;

        return $result;
    }

    static function prepareCompareInfo($data, $queryKey): array
    {
        $metric = self::QUERY_PARAMS[$queryKey];

        $result = [
            'title' => $metric['title'],
            'data' => []
        ];

        switch ($metric["id"]) {
            case "sources_comparison":
                $sources = ["ad", "organic", "direct", "internal", "referral"];

                $metrics = [
                    0 => ["title" => "users", "type" => "number"],
                    1 => ["title" => "visits", "type" => "number"],
                ];
                $result = static::formatReceivedResponse($result, $data, $metrics);

                $others = [
                    "users" => ["current" => 0, "previous" => 0],
                    "visits" => ["current" => 0, "previous" => 0]
                ];

                foreach ($result["data"]["items"] as $sourceId => $sourceMetrics) {
                    if (!in_array($sourceId, $sources)) {
                        $others["users"]["current"] += $sourceMetrics["users"]["current"];
                        $others["users"]["previous"] += $sourceMetrics["users"]["previous"];
                        $others["visits"]["current"] += $sourceMetrics["visits"]["current"];
                        $others["visits"]["previous"] += $sourceMetrics["visits"]["previous"];
                        unset($result["data"]["items"][$sourceId]);
                    }
                }

                $result["data"]["items"]["others"] = $others;
                break;
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    static function parseResult($result, $queryKey)
    {
        if (!empty($result->errors)) {
            throw new Exception($result->message, 0);
        }

        try {
            if (empty(self::QUERY_PARAMS[$queryKey]['prepareData'])) {
                return [];
            }

            $fn = self::QUERY_PARAMS[$queryKey]['prepareData'];

            return static::$fn($result, $queryKey);
        } catch (\Throwable) {
            throw new Exception("Ошибка обработки ответа", 0);
        }
    }


    public static function prepareMetricComparisonResult($property): array
    {
        $property["diff"] = $property["current"] - $property["previous"];

        $metricsToBeRounded = ["percentage", "time", "float"];
        if (in_array($property["type"], $metricsToBeRounded)) {
            $property["current"] = round($property["current"], 1);
            $property["previous"] = round($property["previous"], 1);
            $property["diff"] = $property["current"] - $property["previous"];
        }

        $property["isBetter"] = !empty($property["reversed"]) ? $property["diff"] < 0 : $property["diff"] >= 0;

        $metric = '';

        switch ($property["type"]) {
            case "percentage":
                $metric = '%';
                break;

            case "time":
                $property["diffDisplay"] = ($property["current"] < $property["previous"] ? '-' : '+') . date(
                        "i:s",
                        abs($property["diff"])
                    );
                $property["currentDisplay"] = date("i:s", $property["current"]);
                $property["previousDisplay"] = date("i:s", $property["previous"]);
                break;

            case "float":
                $property["currentDisplay"] = number_format($property["current"], 1, '.', ' ');
                $property["previousDisplay"] = number_format($property["previous"], 1, '.', ' ');
                $property["diffDisplay"] = number_format($property["diff"], 1, '.', ' ');
                break;

            case "number":
                $property["currentDisplay"] = number_format($property["current"], 0, '.', ' ');
                $property["previousDisplay"] = number_format($property["previous"], 0, '.', ' ');
                $property["diffDisplay"] = number_format($property["diff"], 0, '.', ' ');
                break;
        }

        if (!$property["currentDisplay"]) {
            $property["currentDisplay"] = $property["current"];
        }
        if (!$property["previousDisplay"]) {
            $property["previousDisplay"] = $property["previous"];
        }
        if (!$property["diffDisplay"]) {
            $property["diffDisplay"] = $property["diff"];
        }

        $property["diffDisplay"] = (string)$property["diffDisplay"];
        $property["diffDisplay"] = (!in_array($property["diffDisplay"][0], ['+', '-']
            ) ? '+' : '') . $property["diffDisplay"];

        $property["currentDisplay"] .= $metric;
        $property["previousDisplay"] .= $metric;
        $property["diffDisplay"] .= $metric;

        return $property;
    }

    /**
     * @throws Exception
     */
    static function prepareForView($result): array
    {
        try {
            if (!empty($result["data"])) {
                foreach ($result["data"]["items"] as &$sourceMetrics) {
                    foreach ($sourceMetrics as $metricName => $property) {
                        $sourceMetrics[$metricName] = self::prepareMetricComparisonResult($property);
                    }

                    unset($sourceMetrics);
                }

                foreach ($result["data"]["total"] as $metricName => $property) {
                    $result["data"]["total"][$metricName] = self::prepareMetricComparisonResult($property);
                }
            }

            return $result;
        } catch (\Throwable) {
            throw new Exception("Ошибка подготовки данных к выводу", 0);
        }
    }
}