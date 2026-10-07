<?php

namespace TFRest;

class Response
{
    private mixed $data;

    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    public function send(): void
    {
        echo json_encode(["status" => "ok", "data" => $this->data]);
    }
}