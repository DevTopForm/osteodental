<?php

namespace App\Cabinet;

class Controller
{
    protected array $path;
    public User $user;

    public function setPath($pathStr): void
    {
        $this->path = explode('/', $pathStr);
    }

    public function isDispatchable($pathStr): bool
    {
        return false;
    }

    public function run()
    {
    }

    protected function removePathPrefix($pathStr): string
    {
        $prefix = trim(SYS_CABINET_PATH_PREFIX, '/');
        return trim(substr($pathStr, strlen($prefix)), '/');
    }
}