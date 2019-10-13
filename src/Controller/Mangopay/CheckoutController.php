<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends AbstractController
{
    public function __invoke(Request $request, Mangopay $gateway): Response
    {
        $id = $request->query->get('transactionId');

        $transaction = $gateway->find($id);

        return $this->render('lemonway/creditcard.html.twig', [
            'token' => $transaction->getId(),
            'action' => $this->generateUrl('mangopay_capture')
        ]);
    }
}
