<?php

namespace TFRest;

use Exception;

class RouterFactory
{
    private array $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function create(string $url): Router
    {
        foreach ($this->config as $pattern => $routerClass) {
            if ($this->matchesPattern($pattern, $url)) {
                return $this->instantiateRouter($routerClass, $url);
            }
        }

        throw new Exception("Неизвестный путь. Роутер не найден", 1);
    }

    private function matchesPattern(string $pattern, string $url): bool
    {
        $pattern = trim($pattern, '/');
        $wildcardPattern = str_replace('*', '.*', $pattern);

        return preg_match("#^{$wildcardPattern}$#", $url);
    }

    /**
     * @throws Exception
     */
    private function instantiateRouter(string $className, string $url): Router
    {
        if (!class_exists($className)) {
            throw new Exception("Роутер {$className} не найден", 1);
        }
        return new $className($url);
    }
}