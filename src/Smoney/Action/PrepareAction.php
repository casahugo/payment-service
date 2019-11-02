<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\ArrayableInterface;
use App\Enum\PaymentType;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Prepare;
use App\Smoney\Response\ResponsePrepare;
use App\Smoney\Smoney;
use Symfony\Component\Routing\RouterInterface;

class PrepareAction extends AbstractAction
{
    /**
     * @param ArrayableInterface $request
     * @return ArrayableInterface
     */
    public function execute($request)
    {
        $transaction = $this->storage->saveTransaction(
            $request->toArray()['OrderId'],
            Smoney::class,
            PaymentType::CREDITCARD,
            $request->toArray()
        );

        return new ResponsePrepare(
            $transaction,
            $this->router->generate('smoney_checkout', [
                'transactionId' => $transaction->getId()
            ], RouterInterface::ABSOLUTE_URL) ?? ''
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Prepare && Smoney::class === $class;
    }
}
