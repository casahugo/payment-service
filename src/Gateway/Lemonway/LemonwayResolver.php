<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
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

    public function resolveCreditCard(array $data)
    {
        $this
            ->setDefined(['amountCom', 'comment', 'delayedDays', 'email'])
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

    private function getDefaultParams(): array
    {
        return [
            'wlPass',
            'wlLogin',
            'language',
            'version',
            'walletIp',
            'walletUa',
        ];
    }
}