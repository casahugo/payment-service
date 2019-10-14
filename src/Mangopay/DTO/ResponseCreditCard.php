<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;

class ResponseCreditCard implements ArrayableInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $redirectUrl;

    /** @var array  */
    private $data;

    public function __construct(int $id, string $redirectUrl, array $data = null)
    {
        $this->id = $id;
        $this->data = $data;
        $this->redirectUrl = $redirectUrl;
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
            'Status' => 'CREATED',
            'ResultCode' => '001014',
            'ResultMessage' => '',
            'ExecutionDate' => '',
            'Type' => 'PAYIN',
            'Nature' => 'REGULAR',
            'CreditedWalletId' => $this->data['CreditedWalletId'] ?? null,
            'DebitedWalletId' => $this->data['DebitedWalletId'] ?? null,
            'PaymentType' => 'CARD',
            'ExecutionType' => 'WEB',
            'RedirectURL' => $this->redirectUrl,
            'ReturnURL' => $this->data['ReturnURL'] . '&transactionId=' . $this->id,
            'TemplateURL' => $this->data['ReturnURL'] . '&transactionId=' . $this->id,
            'CardType' => $this->data['CardType'] ?? null,
            'Culture' => $this->data['Culture'] ?? null,
            'SecureMode' => $this->data['SecureMode'] ?? null,
            'StatementDescriptor' => $this->data['StatementDescriptor'] ?? null,
        ];
    }
}
