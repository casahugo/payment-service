<?php

declare(strict_types=1);

namespace App\Lemonway;

use App\Entity\Transaction;
use App\Gateway\GatewayResolverInterface;
use App\Gateway\TransactionInterface;
use App\Mangopay\Response\RequestCreateUser;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LemonwayResolver extends OptionsResolver implements GatewayResolverInterface
{
    public const LOGIN = 'login';

    public const PASS = 'password';

    public function __construct()
    {
        $this
            ->setRequired($this->getDefaultParams())
            ->setAllowedValues('wlPass', [static::PASS])
            ->setAllowedValues('wlLogin', [static::LOGIN])
        ;
    }

    public function resolvePrepare(array $data): array
    {
        return $this
            ->setDefined(['amountCom', 'comment', 'delayedDays', 'email', 'language'])
            ->setRequired(['wallet', 'amountTot', 'wkToken', 'returnUrl', 'errorUrl', 'cancelUrl'])
            ->setDefaults([
                'useRegisteredCard' => 0,
                'isPreAuth' => 0,
                'autoCommission' => 0,
                'registerCard' => 0,
                'moneyInNature' => 0,
            ])
            ->resolve($data['p'])
        ;
    }

    public function resolveTransaction(array $data): TransactionInterface
    {
         $data = $this
            ->setDefined([
                'transactionId',
                'transactionComment',
                'transactionMerchantToken',
                'startDate',
                'endDate'
            ])
            ->resolve($data['p'])
         ;

        return (new Transaction())->setReference($data['transactionMerchantToken']);
    }

    private function getDefaultParams(): array
    {
        return [
            'wlPass',
            'wlLogin',
            'version',
            'walletIp',
            'walletUa',
        ];
    }

    public function resolveUser(array $data): RequestCreateUser
    {
        // TODO: Implement resolveUser() method.
    }

    public function resolveCheckout(array $data): string
    {
        return (string) $this->setRequired(['moneyInToken'])->resolve($data)['moneyInToken'];
    }
}
