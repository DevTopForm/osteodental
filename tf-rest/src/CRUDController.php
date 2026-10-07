<?php

namespace TFRest;


use Exception;

abstract class CRUDController
{
    /**
     * @throws Exception
     */
    public function indexAction(array $urlParts = []): Response
    {
        throw new Exception("Метод indexAction не реализован для класса " . get_class($this));
    }

    /**
     * @throws Exception
     */
    public function createAction(array $urlParts = []): Response
    {
        throw new Exception("Метод createAction не реализован для класса " . get_class($this));
    }

    /**
     * @throws Exception
     */
    public function deleteAction(array $urlParts = []): Response
    {
        throw new Exception("Метод deleteAction не реализован для класса " . get_class($this));
    }

    /**
     * @throws Exception
     */
    public function updateAction(array $urlParts = []): Response
    {
        throw new Exception("Метод updateAction не реализован для класса " . get_class($this));
    }
}