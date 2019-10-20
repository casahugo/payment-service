<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Wallet;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseWallet;

class CreateWalletAction extends AbstractAction
{
    /**
     * @param Wallet $request
     * @return ResponseWallet
     */
    public function execute($request)
    {
        return new ResponseWallet($this->storage->saveWallet(
            $request->getUserId(),
            $request->getCurrency(),
            $request->getDescription()
        ));
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Wallet &&
            false === \is_null($request->getCurrency()) &&
            Mangopay::class === $class;
    }
}
