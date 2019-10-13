<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;

class ResponseCreditCard implements ArrayableInterface
{
    /** @var int  */
    private $id;

    /** @var array  */
    private $data;

    public function __construct(int $id, array $data = null)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->id,
            'Tag' => $this->data['Tag'] ?? null,
            'CreationDate' => '1570964049',
            'AuthorId' => $this->data['AuthorId'] ?? null,
            'CreditedUserId' => $this->data['CreditedUserId'] ?? null,
            'DebitedFunds' => $this->data['DebitedFunds'] ?? ['Currency' => 'EUR', 'Amount' => '0',],
            'CreditedFunds' => $this->data['CreditedFunds'] ?? ['Currency' => 'EUR', 'Amount' => '0',],
            'Fees' => $this->data['Fees'] ?? ['Currency' => 'EUR', 'Amount' => '0',],
            'Status' => 'FAILED',
            'ResultCode' => '001014',
            'ResultMessage' => 'CreditedFunds must be more than 0 (DebitedFunds can not equal Fees)',
            'ExecutionDate' => '',
            'Type' => 'PAYIN',
            'Nature' => 'REGULAR',
            'CreditedWalletId' => $this->data['CreditedWalletId'] ?? null,
            'DebitedWalletId' => $this->data['DebitedWalletId'] ?? null,
            'PaymentType' => 'CARD',
            'ExecutionType' => 'WEB',
            'RedirectURL' => '',
            'ReturnURL' => 'http://www.my-site.com/returnURL/?transactionId=69975517',
            'TemplateURL' => 'https://www.mysite.com/template/?transactionId=69975517',
            'CardType' => $this->data['CardType'] ?? null,
            'Culture' => $this->data['Culture'] ?? null,
            'SecureMode' => $this->data['SecureMode'] ?? null,
            'StatementDescriptor' => $this->data['StatementDescriptor'] ?? null,
        ];
    }
}
