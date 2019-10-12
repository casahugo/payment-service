<?php

declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Gateway\Lemonway\Lemonway;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PostMoneyInTokenController
{
    /** @var Lemonway */
    private $lemonway;

    public function __construct(Lemonway $lemonway)
    {
        $this->lemonway = $lemonway;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $token  = $request->request->get('token');
        $error  = $request->request->getInt('error');

        $response = $this->lemonway->getResponseCreditCardPayment($token, $error);

        // Instant Payment Notification
        if ($error === 0) {
            (new Client())->post($response->getEndpoint(), $response->toArray());
        }

        return new RedirectResponse($response->getRedirect());
    }
}
