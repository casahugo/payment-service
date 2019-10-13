<?php

declare(strict_types=1);

namespace App\Mangopay;

use App\Mangopay\DTO\RequestTransactionDetails;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangopayResolver extends OptionsResolver
{
    public function resolveCreditCard(array $data): array
    {
        return $this
            ->setRequired(['AuthorId', 'DebitedFunds', 'Fees', 'ReturnURL', 'CardType', 'CreditedUserId', 'Culture'])
            ->setDefined([
                'Tag',
                'SecureMode',
                'TemplateURLOptions',
                'StatementDescriptor',
                'language',
                'CreditedWalletId',
            ])
            ->setDefaults([
                'SecureMode' => 'DEFAULT',
            ])
            ->resolve($data)
            ;
    }

    public function resolveTransactionDetails(array $data): RequestTransactionDetails
    {
        return new RequestTransactionDetails($data);
    }
}
