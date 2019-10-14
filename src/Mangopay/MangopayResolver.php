<?php

declare(strict_types=1);

namespace App\Mangopay;

use App\Mangopay\DTO\RequestCreateUser;
use App\Mangopay\DTO\RequestTransactionDetails;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangopayResolver extends OptionsResolver
{
    public function resolveCreditCard(array $data): array
    {
        return $this
            ->setRequired(['AuthorId', 'DebitedFunds', 'Fees', 'ReturnURL', 'CardType', 'CreditedWalletId', 'Culture'])
            ->setDefined([
                'Tag',
                'SecureMode',
                'TemplateURLOptions',
                'StatementDescriptor',
                'language',
                'CreditedUserId',
            ])
            ->setDefaults([
                'SecureMode' => 'DEFAULT',
            ])
            ->resolve($data)
            ;
    }

    public function resolveTransactionDetails(int $id): RequestTransactionDetails
    {
        return new RequestTransactionDetails($id);
    }

    public function resolveUser(array $data): RequestCreateUser
    {
        return new RequestCreateUser(
            $this
                ->setRequired(['FirstName', 'LastName', 'Birthday', 'Nationality', 'CountryOfResidence', 'Email'])
                ->setDefined([
                    'Address',
                    'Occupation',
                    'IncomeRange',
                ])
                ->setDefaults([
                    'SecureMode' => 'DEFAULT',
                ])
                ->resolve($data)
        );
    }
}
