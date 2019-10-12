<?php

declare(strict_types=1);

namespace App\Gateway\Lemonway;

use Symfony\Component\OptionsResolver\OptionsResolver;

class LemonwayResolver extends OptionsResolver
{
    public function __construct()
    {
        $this
            ->setRequired($this->getDefaultParams())
            ->setAllowedValues('wlPass', [Lemonway::PASS])
            ->setAllowedValues('wlLogin', [Lemonway::LOGIN])
        ;
    }

    public function resolveCreditCard(array $data): array
    {
        $this
            ->setDefined(['amountCom', 'comment', 'delayedDays', 'email', 'language'])
            ->setRequired(['wallet', 'amountTot', 'wkToken', 'returnUrl', 'errorUrl', 'cancelUrl'])
            ->setDefaults([
                'useRegisteredCard' => 0,
                'isPreAuth' => 0,
                'autoCommission' => 0,
                'registerCard' => 0,
                'moneyInNature' => 0,
            ]);

        return $this->resolve($data);
    }

    public function resolveTransactionDetails(array $data): array
    {
        $this->setDefined([
            'transactionId',
            'transactionComment',
            'transactionMerchantToken',
            'startDate',
            'endDate'
        ]);

        return $this->resolve($data);
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
