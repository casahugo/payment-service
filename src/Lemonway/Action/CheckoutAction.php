<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Checkout;
use App\Gateway\Response\ResponseCheckout;
use App\Gateway\RouterAwareInterface;
use App\Gateway\TraitRouterAware;
use App\Lemonway\Lemonway;
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
        $transaction = $this->storage->findTransaction(null, $request->toArray()['moneyInToken'] ?? null);

        return new ResponseCheckout(
            $transaction->getReference(),
            new Uri($this->router->generate('lemonway_postmoneyintoken'))
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Checkout && Lemonway::class === $class;
    }
}
