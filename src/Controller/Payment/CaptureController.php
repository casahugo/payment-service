<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\Gateway\Contract\ResponseCaptureInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\Capture;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CaptureController
{
    public function __invoke(Request $request, GatewayInterface $gateway): RedirectResponse
    {
        $error  = $request->request->getBoolean('error');

        /** @var ResponseCaptureInterface $response */
        $response = $gateway->execute(new Capture(
            $request->request->get('token', 'invalid'),
            $error
        ));

        if (false === $error) {
            $this->notify($response);
        }

        return new RedirectResponse((string) $response->getRedirect());
    }

    private function notify(ResponseCaptureInterface $request)
    {
        try {
            return (new Client())->post($request->getCallback(), $request->toArray());
        } catch (\Exception $exception) {
            // ...
        }
    }
}
