<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController
{
    public function __invoke()
    {
        return new JsonResponse([
            'access_token' => '67b036bd007c40378d4be5a934f197e6',
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ]);
    }
}
