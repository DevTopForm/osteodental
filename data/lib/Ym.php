<?php

namespace App;

use App\Item\Feedback;
use App\Item\Order;

class Ym
{

    const COUNTER_ID = 107154300;

    const URL = 'https://api-metrika.yandex.net';
    const URL_STATUSES = '/cdp/api/v1/counter/%s/schema/order_statuses';
    const URL_ORDERS = '/cdp/api/v1/counter/%s/data/orders/json?merge_mode=UPDATE';
    const URL_USERS = '/cdp/api/v1/counter/%s/data/contacts/json?merge_mode=UPDATE';
    const URL_ORDERS_SOURCES = '/stat/v1/data';
    const TOKEN = 'y0__xCYrOIRGODaPSCWtaiwFrLLakO95feG_Z4nzn27AVERlDIQ';

    const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    const STATUS_PAID = 'PAID';
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_SPAM = 'SPAM';
    const STATUS_OTHER = 'OTHER';

    private $ch = null;

    private static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setStatuses($statuses): bool
    {
        $data = [
            'order_statuses' => []
        ];

        foreach ($statuses as $status) {
            $data['order_statuses'][] = [
                'id' => $status->id,
                'type' => self::getStatusesList()[$status->id],
                'humanized' => $status->title,
            ];
        }

        $result = $this->getCurlHandler(
            $this->makeUrl(self::URL_STATUSES)
        )->postRequest($data)
            ->curlExec();

        return !empty($result['success']);
    }

    public function exportOrders(array $orders)
    {
        $data = [
            'orders' => []
        ];

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $products = [];

                foreach ($order->data as $product) {
                    $products[] = [

                    ];
                }

                if (empty($order->user->ym_sent)) {
                    $user_data = [
                        'contacts' => [
                            [
                                'uniq_id' => $order->user->id,
                                'name' => $order->user->getName(),
                                'phones' => [$order->user->phone],
                                'emails' => [$order->user->email],
                            ]
                        ]
                    ];

                    $result = $this->getCurlHandler(
                        $this->makeUrl(self::URL_USERS)
                    )->postRequest($user_data)
                        ->curlExec();

                    if (
                        !empty($result['uploading']['api_validation_status'])
                        && $result['uploading']['api_validation_status'] == 'PASSED'
                    ) {
                        User::simpleSave($order->user->id, 'ym_sent', 1);
                    }
                }

                $data['orders'][] = [
                    'id' => $order->id,
                    'client_uniq_id' => $order->user->id,
                    'client_type' => 'CONTACT',
                    'create_date_time' => $order->date,
                    'order_status' => $order->status->id,
                    'revenue' => $order->totalSumm
                ];
            }

            $result = $this->getCurlHandler(
                $this->makeUrl(self::URL_ORDERS)
            )->postRequest($data)
                ->curlExec();
        }

        return !empty($result['uploading']['api_validation_status']) && $result['uploading']['api_validation_status'] == 'PASSED';
    }

    public function getSources($time, $client_id)
    {
        $params = [
            'ids' => self::COUNTER_ID,
            'metrics' => 'ym:s:visits',
            'sort' => '-ym:s:date',
            'dimensions' => implode(',', [
                'ym:s:date',
                'ym:s:deviceCategory',
                'ym:s:browser',
                'ym:s:lastsignTrafficSource',
            ]),
            'filters' => sprintf('ym:s:clientID==%s', $client_id),
//            'date1' => date('Y-m-d', $time),
//            'date2' => date('Y-m-d', $time),
        ];

        $result = $this->getCurlHandler(
            $this->makeUrl(self::URL_ORDERS_SOURCES, $params)
        )->getRequest()
            ->curlExec();

        return json_encode(
            [
                'source' => !empty($result['data'][0]['dimensions'][3]['name']) ? $result['data'][0]['dimensions'][3]['name'] : '',
                'device' => !empty($result['data'][0]['dimensions'][1])
                    ? sprintf(
                        '%s (%s)',
                        $result['data'][0]['dimensions'][1]['name'],
                        $result['data'][0]['dimensions'][2]['name']
                    )
                    : '',
            ]
        );
    }

    public function getFeedbackSources(Feedback $feedback)
    {
        if (empty($feedback->ym_client_id)) {
            return [];
        }

        return $this->getSources($feedback->date, $feedback->ym_client_id);
    }

    public function getOrderSources(Order $order)
    {

        if (empty($order->ym_client_id)) {
            return [];
        }

        $time = strtotime($order->date);
        return $this->getSources($time, $order->ym_client_id);
    }

    private function getRequest()
    {
        return $this;
    }

    private function postRequest($data)
    {
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $this;
    }

    private function getCurlHandler($url)
    {
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, true); // Для HTTPS
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30); // Таймаут 3
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            sprintf('Authorization: OAuth %s', self::TOKEN)
        ]);
        return $this;
    }

    private function makeUrl($url, $params = []): string
    {
        return self::URL . sprintf($url, self::COUNTER_ID) . (!empty($params) ? '?' . http_build_query($params) : '');
    }

    private function curlExec()
    {
        $response = curl_exec($this->ch);
        curl_close($this->ch);
        return json_decode($response, true);
    }

    public static function getStatusesList(): array
    {
        return [
            '1' => self::STATUS_IN_PROGRESS,
            '2' => self::STATUS_PAID,
            '3' => self::STATUS_PAID,
            '4' => self::STATUS_CANCELLED,
            '5' => self::STATUS_IN_PROGRESS,
            '6' => self::STATUS_SPAM,
            '7' => self::STATUS_PAID,
            '8' => self::STATUS_CANCELLED,
            '9' => self::STATUS_PAID,
            '10' => self::STATUS_IN_PROGRESS,
            '11' => self::STATUS_IN_PROGRESS,
            '12' => self::STATUS_PAID,
            '13' => self::STATUS_PAID,
        ];
    }
}