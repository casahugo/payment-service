<?php

declare(strict_types=1);

namespace App\Mangopay\Response;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;

class ResponseTransaction implements ArrayableInterface
{
    /** @var int  */
    private $id;

    /** @var array  */
    private $data;

    public function __construct(TransactionInterface $transaction)
    {
        $this->id = $transaction->getId();
        $this->data = $transaction->getData();
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->id,
            'Tag' => $this->data['Tag'] ?? null,
            'CreationDate' => '1463495036',
            'AuthorId' => $this->data['AuthorId'] ?? null,
            'CreditedUserId' => $this->data['CreditedUserId'] ?? null,
            'DebitedFunds' => [
                'Currency' => 'EUR',
                'Amount' => '100',
            ],
            'CreditedFunds' => [
                'Currency' => 'EUR',
                'Amount' => '100',
            ],
            'Fees' => [
                'Currency' => 'EUR',
                'Amount' => '100',
            ],
            'Status' => 'SUCCEEDED',
            'ResultCode' => '000000',
            'ResultMessage' => 'Success',
            'ExecutionDate' => '1463495037',
            'Type' => 'PAYIN',
            'Nature' => 'REGULAR',
            'CreditedWalletId' => $this->data['CreditedWalletId'] ?? null,
            'DebitedWalletId' => $this->data['DebitedWalletId'] ?? null,
            'PaymentType' => 'CARD',
            'ExecutionType' => 'DIRECT',
            'SecureMode' => 'DEFAULT',
            'CardId' => '12639018',
            'SecureModeReturnURL' => '',
            'SecureModeRedirectURL' => '',
            'SecureModeNeeded' => '',
            'Billing' => [
                'Address' => [
                    'AddressLine1' => '',
                    'AddressLine2' => '',
                    'City' => '',
                    'Region' => '',
                    'PostalCode' => '',
                    'Country' => '',
                ],
            ],
            'Culture' => '',
            'SecurityInfo' => [
                'AVSResult' => 'NO_CHECK',
            ],
            'StatementDescriptor' => $this->data['StatementDescriptor'] ?? null,
        ];
    }
}
