<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\ArrayableInterface;
use App\Enum\PaymentType;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Prepare;
use App\Gateway\RouterAwareInterface;
use App\Gateway\TraitRouterAware;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponsePrepare;
use Faker\Factory;
use Symfony\Component\Routing\RouterInterface;

class PrepareAction extends AbstractAction implements RouterAwareInterface
{
    use TraitRouterAware;

    /**
     * @param ArrayableInterface $request
     * @return ArrayableInterface
     */
    public function execute($request)
    {
        $transaction = $this->storage->saveTransaction(
            Factory::create()->md5,
            PaymentType::CREDITCARD,
            $request->toArray()
        );

        return new ResponsePrepare(
            $transaction->getId(),
            $this->router->generate('mangopay_checkout', [
                'transactionId' => $transaction->getId()
            ], RouterInterface::ABSOLUTE_URL),
            $request->toArray()
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Prepare && Mangopay::class === $class;
    }
}
