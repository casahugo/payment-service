<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use App\Mangopay\Mangopay;
use GuzzleHttp\Psr7\Uri;

class CheckoutAction extends AbstractAction
{
    /**
     * @param Checkout $request
     * @return ResponseCheckout
     */
    public function execute($request)
    {
        return new ResponseCheckout(
            $request->getTransaction(),
            new Uri($this->router->generate('mangopay_capture'))
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Checkout && Mangopay::class === $class;
    }
}
