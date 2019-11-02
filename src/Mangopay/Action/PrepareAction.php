<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\ArrayableInterface;
use App\Enum\PaymentType;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Prepare;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponsePrepare;
use Faker\Factory;
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
            Factory::create()->md5,
            Mangopay::class,
            PaymentType::CREDITCARD,
            $request->toArray()
        );

        return new ResponsePrepare(
            $transaction,
            $this->router->generate('mangopay_checkout', [
                'transactionId' => $transaction->getId()
            ], RouterInterface::ABSOLUTE_URL)
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Prepare && Mangopay::class === $class;
    }
}
