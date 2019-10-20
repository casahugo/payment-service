<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use App\Gateway\RouterAwareInterface;
use App\Gateway\TraitRouterAware;
use App\Mangopay\Mangopay;
use GuzzleHttp\Psr7\Uri;

class CheckoutAction extends AbstractAction implements RouterAwareInterface
{
    use TraitRouterAware;

    /**
     * @param Checkout $request
     * @return ResponseCheckout
     */
    public function execute($request)
    {
        $id = $request->toArray()['transactionId'] ?? null;

        $transaction = $this->storage->findTransaction((int) $id);

        return new ResponseCheckout(
            $transaction->getReference(),
            new Uri($this->router->generate('mangopay_capture'))
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Checkout && Mangopay::class === $class;
    }
}
