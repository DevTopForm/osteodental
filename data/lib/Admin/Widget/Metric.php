<?php

namespace App\Admin\Widget;

use App\Query;
use App\Utils;
use App\Admin\YandexMetric;
use Exception;

class Metric extends Widget
{
    const FILTER_NAME = 'metric_between';
    public string $error = "";
    public array $filters;

    protected function setTemplateData(): void
    {
        $this->filters = $this->getFilters();
        $this->tpl->assign('interval', $this->getInterval());
        $this->tpl->assign('filter_name', static::FILTER_NAME);
        $this->tpl->assign('content', $this->calculateAndPrepareData());
        $this->tpl->assign('error', $this->error);
        $this->tpl->assign('widget', $this->widget);
    }

    protected function calculateAndPrepareData(): array | null
    {
        if (empty($this->widget->metric_id) || empty($this->widget->metric_token)) {
            $this->error = "Заполните id счётчика и token в настройках виджета";
            return null;
        }

        $params = [
            "counterId" => $this->widget->metric_id,
            "from" => $this->filters["date"]["from"],
            "till" => $this->filters["date"]["till"],
        ];

        try {
            $preparedParams = YandexMetric::prepareParams("sources_comparison", $params);
            $result = YandexMetric::doRequest($preparedParams, $this->widget->metric_token);
            $result = YandexMetric::parseResult($result, "sources_comparison");
            return YandexMetric::prepareForView($result);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return [];
        }
    }

    protected function getInterval()
    {
        $getFilter = Query::$get[static::FILTER_NAME];

        if (!empty($getFilter)) {
            return $getFilter;
        } else {
            $month = date('n', time());
            return mb_strtolower(Utils::RUSSIAN_MONTHS[$month - 1]);
        }
    }

    protected function getFilters(): array
    {
        $getFilters = Query::$get[static::FILTER_NAME];
        $filters = [];

        if (!empty($getFilters)) {
            $getFilters = explode(' — ', $getFilters);
            $filters['date']["from"] = strtotime($getFilters[0]);
            $filters['date']["till"] = $getFilters[1] ? strtotime($getFilters[1]) : strtotime($getFilters[0]);
        } else {
            $monthStart = sprintf(
                "%s-%s-01 00:00:00",
                date('Y', time()),
                date('m', time())
            );

            $filters['date']["from"] = strtotime($monthStart);
            $filters['date']["till"] = time();
        }

        return $filters;
    }
}