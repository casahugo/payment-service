<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Gateway\Lemonway\Lemonway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MoneyInTokenController extends AbstractController
{
    /** @var Lemonway  */
    private $lemonway;

    public function __construct(Lemonway $lemonway)
    {
        $this->lemonway = $lemonway;
    }

    public function __invoke(Request $request): Response
    {
        $token = $request->query->get('moneyintoken');

        if (is_null($token)) {
            throw new BadRequestHttpException('missing moneyintoken');
        }

        return $this->render('lemonway/creditcard.html.twig');
    }
}