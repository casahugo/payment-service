<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Entity\Wallet as WalletEntity;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Wallet;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseWallet;
use App\Mangopay\Response\ResponseWallets;

class GetWalletAction extends AbstractAction
{
    /**
     * @param Wallet $request
     * @return ResponseWallets
     */
    public function execute($request)
    {
        $wallets = $this->storage->findUserWallet($request->getUserId());

        return new ResponseWallets(array_map(function (WalletEntity $wallet): ResponseWallet {
            return new ResponseWallet($wallet);
        }, $wallets));
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Wallet &&
            is_null($request->getCurrency()) &&
            Mangopay::class === $class;
    }
}
