<?php

declare(strict_types=1);

namespace App\Smoney;

use App\Entity\Transaction;
use App\Gateway\GatewayResolverInterface;
use App\Gateway\TransactionInterface;
use App\Gateway\UserInterface;
use App\Smoney\Response\RequestCreateUser;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmoneyResolver extends OptionsResolver implements GatewayResolverInterface
{
    public function resolvePrepare(array $data): array
    {
        $this->setRequired([
            'OrderId',
            'UrlReturn',
            'PayerInfo',
        ]);

        $this->setDefined([
            'Id',
            'OrderId',
            'PaymentDate',
            'Amount',
            'Fee',
            'Status',
            'Beneficiary',
            'Message',
            'IsMine',
            'ErrorCode',
            'ExtraResults',
            'UrlReturn',
            'UrlCallback',
            'AvailableCards',
            'Type',
            'Card',
            'PaymentSchedule',
            'Payments',
            'PayerInfo',
            'Require3DS',
            'Extraparameters',
        ]);

        return $this->resolve($data);
    }

    public function resolveTransaction(array $data): TransactionInterface
    {
        return (new Transaction())->setReference($data['reference']);
    }

    public function resolveUser(array $data): UserInterface
    {
        return new RequestCreateUser($this->setDefined([
            'AppUserId',
            'Type',
            'Profile',
            'Company'
        ])->resolve($data));
    }

    public function resolveCheckout(array $data): int
    {
        return (int) $this->setRequired(['transactionId'])->resolve($data)['transactionId'];
    }

    public function resolveWallet(array $data)
    {
        // TODO: Implement resolveWallet() method.
    }
}
