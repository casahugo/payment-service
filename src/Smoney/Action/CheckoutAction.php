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

    /**
     * @param Checkout $request
     * @return ResponseCheckout
     */
    public function execute($request)
    {
        return new ResponseCheckout(
            $request->getTransaction(),
            new Uri($this->router->generate('smoney_capture'))
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Checkout && Smoney::class === $class;
    }
}
