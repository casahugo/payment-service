<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use App\Lemonway\Lemonway;
use GuzzleHttp\Psr7\Uri;

class CheckoutAction extends AbstractAction
{
    /**
     * @param Checkout $request
     * @return ResponseCheckout
     */
    public function execute($request): ResponseCheckout
    {
        return new ResponseCheckout(
            $request->getTransaction(),
            new Uri($this->router->generate('lemonway_capture'))
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Checkout && Lemonway::class === $class;
    }
}
