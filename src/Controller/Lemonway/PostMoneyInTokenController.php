<?php

declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Lemonway\DTO\RequestCreditCardPayment;
use App\Lemonway\Lemonway;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PostMoneyInTokenController
{
    public function __invoke(Request $request, Lemonway $lemonway): RedirectResponse
    {
        $token  = $request->request->get('token', 'invalid');
        $error  = $request->request->getInt('error');

        $request = $lemonway->getRequestCreditCardPayment($token, $error);

        if ($error === 0) {
            $this->notify($request);
        }

        return new RedirectResponse((string) $request->getRedirect());
    }

    private function notify(RequestCreditCardPayment $requestCreditCardPayment): ResponseInterface
    {
        return (new Client())->post(
            $requestCreditCardPayment->getEndpoint(),
            $requestCreditCardPayment->toArray()
        );
    }
}
