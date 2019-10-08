<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Controller\Lemonway;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MoneyInWebInitController
{
    public function __invoke(Request $request): Response
    {
        // Redirect URL
        return new Response();
    }
}