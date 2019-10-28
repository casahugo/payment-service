<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\Gateway\GatewayInterface;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends AbstractController
{
    public function __invoke(Request $request, GatewayInterface $gateway): Response
    {
        /** @var ResponseCheckout $response */
        $response = $gateway->execute(new Checkout(
            $gateway->resolver()->resolveCheckout($request->query->all())
        ));

        return $this->render('checkout/creditcard.html.twig', [
            'transactionId' => $response->getTransaction()->getId(),
            'action' => $response->getAction()
        ]);
    }
}
