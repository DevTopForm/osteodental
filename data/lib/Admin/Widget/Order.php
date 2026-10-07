<?php

namespace App\Admin\Widget;

use App\Item\Order as ItemOrder;
use App\Query;

class Order extends Feedback
{
    const ITEMS_TABLE = 'order_shop';
    const ITEMS_CLASS = ItemOrder::class;
    const FILTER_NAME = 'order_between';


    protected function getNewFilter()
    {
        return [
            '`status` = ' . $this->db->query(
                'SELECT `id` FROM `order_status` WHERE `is_new` = 1',
                $this->db::QUERY_MODE_EXECUTE
            )->current()['id'] ?? 0
        ];
    }

    protected function getCount()
    {
        $filters = implode(' AND ', $this->filters);
        $where = !empty($filters) ? sprintf('WHERE %s', $filters) : '';

        $result = $this->db->query(
            sprintf('SELECT COUNT(`id`) as `all`, SUM(`orderSumm`) as summ FROM %s %s', static::ITEMS_TABLE, $where),
            $this->db::QUERY_MODE_EXECUTE
        )->current();

        $where = str_replace('`date`', 't.`date`', $where);
        $result['statuses'] = $this->db->query(
            sprintf(
                'SELECT os.`title` as `title`, COUNT(t.`id`) as `count`, SUM(t.`orderSumm`) as summ FROM %s as t INNER JOIN `order_status` as os ON t.`status` = os.`id` %s GROUP BY t.`status` ORDER BY `count` DESC',
                static::ITEMS_TABLE,
                $where
            ),
            $this->db::QUERY_MODE_EXECUTE
        )->toarray();

        return $result;
    }

    protected function getFilters()
    {
        $get_filter = Query::$get[static::FILTER_NAME];
        $filters = [];

        if (!empty($get_filter)) {
            $get_filter = explode(' — ', $get_filter);
            $filters['date'] = sprintf(
                "`date` BETWEEN '%s' AND '%s'",
                date('Y-m-d H:i:s', strtotime($get_filter[0])),
                date('Y-m-d H:i:s', strtotime($get_filter[1]))
            );
        } else {
            $month_start = sprintf(
                "%s-%s-01 00:00:00",
                date('Y', time()),
                date('m', time())
            );

            $filters['date'] = sprintf("`date` BETWEEN '%s' AND '%s'", $month_start, date('Y-m-d H:i:s', time()));
        }

        return $filters;
    }

    protected function setTemplateData()
    {
        parent::setTemplateData();
        $this->tpl->assign('payments', (new ItemOrder())->deliveryPaymentMethodArray);
    }
}