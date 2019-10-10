<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Gateway\Lemonway\Lemonway;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MoneyInTokenController
{
    /** @var Lemonway  */
    private $lemonway;

    public function __construct(Lemonway $lemonway)
    {
        $this->lemonway = $lemonway;
    }

    public function __invoke(Request $request)
    {
        $token = $request->query->get('moneyintoken');

        if (is_null($token)) {
            throw new BadRequestHttpException('missing moneyintoken');
        }
    }
}