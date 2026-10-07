<?php

namespace App\Admin\Widget;

use App\Admin\Template;
use App\Query;
use App\Item\Feedback as ItemFeedback;
use App\Utils;

class Feedback extends Widget
{
    const ITEMS_TABLE = 'result_feedback';
    const ITEMS_CLASS = ItemFeedback::class;
    const FILTER_NAME = 'feedback_between';

    protected array $filters = [];

    protected function setTemplateData()
    {


        $this->filters = $this->getFilters();
        $this->tpl->assign('interval', $this->getInterval());
        $this->tpl->assign('filter_name', static::FILTER_NAME);
        $this->tpl->assign('new_count', $this->getNewCount());
        $this->tpl->assign('list', $this->getList());
        $this->tpl->assign('count', $this->getCount());
        $this->tpl->assign('widget', $this->widget);
    }

    protected function getNewCount()
    {
        $filter = $this->getNewFilter();
        $where = !empty($filter) ? sprintf('WHERE %s', implode(' AND ', $filter)) : '';

        try {
            return $this->db->query(
                sprintf('SELECT count(`id`) as `count` FROM %s %s', static::ITEMS_TABLE, $where),
                $this->db::QUERY_MODE_EXECUTE
            )->current()['count'];
        } catch (\Throwable $e){
            return  0;
        }
    }

    protected function getNewFilter()
    {
        return [
           '`public` = 0'
        ];
    }

    protected function getList()
    {
        return static::ITEMS_CLASS::getList(['filters' => $this->filters, 'sorters' => ['id desc']], 5)->getItems();
    }

    protected function getCount()
    {

        $filter_all = implode(' AND ', $this->filters);

        if(!empty($filter_all)) {
            $filter_spam = implode(' AND ', [$filter_all, "`spam` = 1"]);
        }else{
            $filter_spam = implode(' AND ', ["`spam` = 1"]);
        }

        $result = [];

        foreach (['all' => $filter_all, 'spam' => $filter_spam] as $key => $value){
            $where = !empty($value) ? sprintf('WHERE %s', $value) : '';

            $result[$key] = $this->db->query(
                sprintf('SELECT count(`id`) as `count` FROM %s %s', static::ITEMS_TABLE, $where),
                $this->db::QUERY_MODE_EXECUTE
            )->current()['count'];
        }

        return $result;
    }

    protected function getFilters()
    {
        $get_filter = Query::$get[static::FILTER_NAME];
        $filters = [];

        if (!empty($get_filter)) {

            $get_filter = explode(' — ', $get_filter);
            $filters['date'] = sprintf("`date` BETWEEN %s AND %s", strtotime($get_filter[0]), strtotime($get_filter[1]));
        }else{
            $month_start = sprintf(
                "%s-%s-01 00:00:00",
                date('Y', time()),
                date('m', time())
            );
            $month_start = strtotime($month_start);
            $filters['date'] = sprintf("`date` BETWEEN %s AND %s", $month_start, time());
        }

        return $filters;
    }

    protected function getInterval()
    {
        $get_filter = Query::$get[static::FILTER_NAME];

        if (!empty($get_filter)) {
            return $get_filter;
        }else{
            $month = date('n', time());
            return mb_strtolower(Utils::RUSSIAN_MONTHS[$month - 1]);
        }
    }
}