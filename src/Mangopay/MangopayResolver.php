<?php

declare(strict_types=1);

namespace App\Mangopay;

use App\Entity\Transaction;
use App\Gateway\GatewayResolverInterface;
use App\Gateway\TransactionInterface;
use App\Mangopay\Response\RequestCreateUser;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangopayResolver extends OptionsResolver implements GatewayResolverInterface
{
    public function resolvePrepare(array $data): array
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

    public function resolveTransaction(array $data): TransactionInterface
    {
        return (new Transaction())->setId((int) $data['id']);
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
