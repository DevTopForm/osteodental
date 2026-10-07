<?php

namespace TFRest;

abstract class Router
{
    protected string $url;
    protected array $urlParts = [];
    protected string $controllerClass;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->urlParts = explode("/", trim($url, "/"));
    }

    /**
     * Base route method using controller
     * @return Response
     */
    abstract public function route(): Response;
}