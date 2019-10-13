<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Lemonway\Lemonway;

class GatewayName
{
    public const HIPAY = 'HiPay';

    public const LEMONWAY = Lemonway::class;

    public const STRIPE = 'Stripe';

    public const MANGOPAY = 'MangoPay';

    public const SMONEY = 'SMoney';
}
