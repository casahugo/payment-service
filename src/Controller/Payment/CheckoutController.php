<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\Storage\StorageInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends AbstractController
{
    public function __invoke(Request $request, GatewayInterface $gateway, StorageInterface $storage): Response
    {
        /** @var ResponseCheckout $response */
        $response = $gateway->execute(new Checkout($request->query->all()));

        return $this->render('checkout/creditcard.html.twig', [
            'token' => $response->getReference(),
            'action' => $response->getAction()
        ]);
    }
}