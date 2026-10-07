<?php

namespace TFRest\Service;

use Exception;

class AuthService
{
    private array $apiTokens;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/auth.php';
        $this->apiTokens = $config['api_tokens'] ?? [];
    }

    /**
     * @throws Exception
     */
    public function check(): void
    {
        $token = $_SERVER['HTTP_X_API_TOKEN'] ?? $this->getTokenFromBearer();

        if (empty($this->apiTokens) || !in_array($token, $this->apiTokens)) {
            throw new Exception("Неавторизованный запрос. Неверный или отсутствует API токен.", 401);
        }
    }

    private function getTokenFromBearer(): ?string
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';

        if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
