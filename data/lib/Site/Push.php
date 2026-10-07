<?php

namespace App\Site;

use App\Item\Order;
use App\Registry;

abstract class Push
{
    protected $type;
    protected $db;
    protected $table = "push_message";

    public function __construct()
    {
        $this->db = Registry::get('db');
    }

    protected function getPersonal($id)
    {
        $order = new Order($id);
        return [
            "email" => $order->email,
            "phone" => $order->phone
        ];
    }

    protected function getData()
    {
    }

    protected function save()
    {
        $data = $this->getData();
        if (!empty($this->id)) {
            $update = $this->db->sql->update();
            $update->table($this->table);
            $update->set($data);
            $update->where('id=' . $this->id);
            $this->db->query($this->db->sql->buildSqlString($update), $this->db::QUERY_MODE_EXECUTE);
        } else {
            $insert = $this->db->sql->insert();
            $insert->into($this->table);
            $insert->columns(array_keys($data));
            $insert->values($data);
            $this->db->query($this->db->sql->buildSqlString($insert), $this->db::QUERY_MODE_EXECUTE);
            $this->id = $this->db->getDriver()->getConnection()->getLastGeneratedValue();
        }
    }

    public function run()
    {
    }
}