<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\DTO\RequestCreditCardPayment;
use App\Mangopay\Mangopay;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CaptureController
{
    public function __invoke(Request $request, Mangopay $gateway): RedirectResponse
    {
        $token  = $request->request->get('token', 'invalid');
        $error  = $request->request->getInt('error');

        $request = $gateway->getRequestCreditCardPayment($token, $error);

        if ($error === 0) {
            $this->notify($request);
        }

        return new RedirectResponse((string) $request->getRedirectUrl());
    }

    private function notify(RequestCreditCardPayment $requestCreditCardPayment): ResponseInterface
    {
        return (new Client())->get(
            $requestCreditCardPayment->getEndpoint(),
            $requestCreditCardPayment->toArray()
        );
    }
}
