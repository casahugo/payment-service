<?php

declare(strict_types=1);

namespace App\Mangopay\Response;

use App\Gateway\Contract\ResponseCreateUserInterface;
use App\Gateway\UserInterface;

class ResponseCreateUser implements ResponseCreateUserInterface
{
    /** @var int  */
    private $userId;

    /** @var UserInterface  */
    private $user;

    public function __construct(int $userId, UserInterface $user)
    {
        $this->user = $user;
        $this->userId = $userId;
    }

    public function toArray(): array
    {
        return [
            'Address' => [
                'AddressLine1' => '1 Mangopay Street',
                'AddressLine2' => 'The Loop',
                'City' => 'Paris',
                'Region' => 'Ile de France',
                'PostalCode' => '75001',
                'Country' => 'FR',
            ],
            'FirstName' => $this->user->getFirstname(),
            'LastName' => $this->user->getLastname(),
            'Birthday' => '1463496101',
            'Nationality' => 'GB',
            'CountryOfResidence' => 'FR',
            'Occupation' => 'Carpenter',
            'IncomeRange' => '2',
            'ProofOfIdentity' => '',
            'ProofOfAddress' => '',
            'Capacity' => 'NORMAL',
            'PersonType' => 'NATURAL',
            'Email' => $this->user->getEmail(),
            'KYCLevel' => 'LIGHT',
            'Id' => $this->userId,
            'Tag' => '',
            'CreationDate' => '1570999210',
        ];
    }
}
