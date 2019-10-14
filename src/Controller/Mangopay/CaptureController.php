<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\DTO\RequestCreditCardPayment;
use App\Mangopay\Mangopay;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureController
{
    public function __invoke(Request $request, Mangopay $gateway): Response
    {
        $token  = $request->request->get('token', 'invalid');
        $error  = $request->request->getInt('error');

        $request = $gateway->getRequestCreditCardPayment($token, $error);

        if ($error === 0) {
            $this->notify($request);
        }

        return new RedirectResponse((string) $request->getRedirectUrl());
    }

    private function notify(RequestCreditCardPayment $requestCreditCardPayment)
    {
        try {
            return (new Client())->post($requestCreditCardPayment->getCallback());
        } catch (\Exception $exception) {
            // ...
        }
    }
}
