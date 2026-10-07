<?php

ini_set('display_errors','On');
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

use TFRest\RouterFactory;
use TFRest\Service\AuthService;

header("Content-Type: application/json");

$url = (isset($_GET['url'])) ? trim($_GET['url'], '/') : '';

$routesConfig = require __DIR__ . '/config/routes.php';

try {
    $authService = new AuthService();
    $authService->check();

    $factory = new RouterFactory($routesConfig);
    $router = $factory->create($url);
    $response = $router->route();
    $response->send();
} catch (Throwable $exception) {
    if ($exception->getCode() === 401) {
        header('HTTP/1.1 401 Unauthorized');
    }
    echo json_encode(["status" => "error", "error" => $exception->getMessage()]);
}

