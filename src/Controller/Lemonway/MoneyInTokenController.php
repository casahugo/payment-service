<?php

declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Gateway\Lemonway\Lemonway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MoneyInTokenController extends AbstractController
{
    public function __invoke(Request $request, Lemonway $lemonway): Response
    {
        $token = $request->query->get('moneyInToken');

        if (false === $lemonway->verifyToken($token)) {
            throw new BadRequestHttpException('token is invalid.');
        }

        return $this->render('lemonway/creditcard.html.twig', [
            'token' => $token,
            'action' => $this->generateUrl('lemonway_postmoneyintoken')
        ]);
    }
}
