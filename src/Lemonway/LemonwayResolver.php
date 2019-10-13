<?php

declare(strict_types=1);

namespace App\Lemonway;

use App\Lemonway\DTO\RequestTransactionDetails;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LemonwayResolver extends OptionsResolver
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

    public function resolveCreditCard(array $data): array
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
            ->resolve($data)
        ;
    }

    public function resolveTransactionDetails(array $data): RequestTransactionDetails
    {
        return new RequestTransactionDetails(
            $this
                ->setDefined([
                    'transactionId',
                    'transactionComment',
                    'transactionMerchantToken',
                    'startDate',
                    'endDate'
                ])
                ->resolve($data)
        );
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
}
