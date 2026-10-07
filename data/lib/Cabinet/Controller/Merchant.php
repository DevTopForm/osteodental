<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Params;
use App\Query;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class Merchant extends Controller
{
    public function isDispatchable($pathStr): bool
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^(merchant)|(merchant\/.*)$/', $pathStr);
    }

    #[NoReturn] public function run(): void
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        if (!in_array($path[1], $this->getAvailableMerchantInterfaces())) {
            die('Unavailable merchant interface');
        }
        $method = sprintf('process%sRequest', ucfirst($path[1]));
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            die('Unavailable merchant method');
        }
        die();
    }

    private function getAvailableMerchantInterfaces(): array
    {
        $merchants = [];
        foreach (Params::$params['merchant'] as $key => $item) {
            $merchants[] = $key;
        }
        return $merchants;
    }


    /**
     * @throws Exception
     */
    private function processRobokassaRequest(): void
    {
        try {
            if (empty(Query::$post['InvId']) || empty(Query::$post['OutSum']) || empty(Query::$post['SignatureValue'])) {
                throw new Exception('Bad request');
            }
            $hash = strtoupper(
                md5(
                    join(":", [
                        Query::$post['OutSum'],
                        Query::$post['InvId'],
                        Params::$params['merchant']['robokassa']['pass_2']
                    ])
                )
            );
            if ($hash != Query::$post['SignatureValue']) {
                throw new exception('Bad hash');
            }
            $item = new Item_Order(Query::$post['InvId']);
            if (empty($item->id)) {
                throw new exception('Order not found');
            }
            if ($item->summ != Query::$post['OutSum']) {
                throw new exception('Wrong summ');
            }
            $item->status = new Item_Order_Status(3);
            $item->save();
            $item->user->updateSale();
            $item->notify('pay');
            echo 'OK' . $item->id;
            die;
        } catch (exception $e) {
            die('ERROR-' . $e->getMessage());
        }
    }
}