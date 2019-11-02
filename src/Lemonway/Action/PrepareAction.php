<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

use App\ArrayableInterface;
use App\Enum\PaymentType;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Prepare;
use App\Lemonway\Lemonway;
use App\Lemonway\Response\ResponsePrepare;
use Faker\Factory;

class PrepareAction extends AbstractAction
{
    /**
     * @param ArrayableInterface $request
     * @return ArrayableInterface
     */
    public function execute($request): ArrayableInterface
    {
        $request->toArray()['cardNumber'] = (int) $request->toArray()['registerCard'] === 1
            ? Factory::create()->randomNumber()
            : null;

        $transaction = $this->storage->saveTransaction(
            Factory::create()->md5,
            Lemonway::class,
            PaymentType::CREDITCARD,
            $request->toArray()
        );

        return new ResponsePrepare($transaction);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Prepare && Lemonway::class === $class;
    }
}
