<?php

namespace TFRest;

abstract class Service
{
    protected string $repositoryClass;
    protected Repository $repository;

    public function __construct()
    {
        $this->repository = new $this->repositoryClass();
    }

    public function getList(array $filters = [], array $sorters = [], $limiter = 10): false|array|null
    {
        return $this->repository->getList($filters, $sorters, $limiter);
    }

    public function getByKey(string $key, string|int $value)
    {
        return $this->repository->getByKey($key, $value);
    }
}