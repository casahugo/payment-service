<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\ArrayableInterface;
use App\Controller\Payment\CheckoutController;
use App\Enum\PaymentType;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Prepare;
use App\Gateway\RouterAwareInterface;
use App\Gateway\TraitRouterAware;
use App\Smoney\Response\ResponsePrepare;
use App\Smoney\Smoney;
use Faker\Factory;

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
            $transaction,
            $this->router->generate(CheckoutController::class, ['transactionId' => $transaction->getId()])
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Prepare && Smoney::class === $class;
    }
}
