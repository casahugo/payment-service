<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use App\Gateway\RouterAwareInterface;
use App\Gateway\TraitRouterAware;
use App\Smoney\Smoney;
use GuzzleHttp\Psr7\Uri;

class CheckoutAction extends AbstractAction implements RouterAwareInterface
{
    use TraitRouterAware;

    public function execute($request)
    {
        $transaction = $this->storage->findTransaction($request->toArray()['transactionId'] ?? null);

        return new ResponseCheckout(
            $transaction->getReference(),
            new Uri($this->router->generate('smoney_capture'))
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Checkout && Smoney::class === $class;
    }
}
