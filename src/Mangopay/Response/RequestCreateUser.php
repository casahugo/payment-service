<?php

declare(strict_types=1);

namespace App\Mangopay\Response;

use App\ArrayableInterface;
use App\Gateway\UserInterface;

class RequestCreateUser implements ArrayableInterface, UserInterface
{
    /** @var array  */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): ?int
    {
        return null;
    }

    public function getEmail(): string
    {
        return $this->data['Email'];
    }

    public function getFirstname(): string
    {
        return $this->data['FirstName'];
    }

    public function getLastname(): string
    {
        return $this->data['LastName'];
    }

    public function toArray(): array
    {
        return [
            'FirstName' => $this->data['FirstName'],
            'LastName' => $this->data['LastName'],
            'Address' => [
                'AddressLine1' => '1 Mangopay Street',
                'AddressLine2' => 'The Loop',
                'City' => 'Paris',
                'Region' => 'Ile de France',
                'PostalCode' => '75001',
                'Country' => 'FR',
            ],
            'Birthday' => $this->data['Birthday'],
            'Nationality' => $this->data['Nationality'],
            'CountryOfResidence' => $this->data['CountryOfResidence'],
            'Occupation' => 'Carpenter',
            'IncomeRange' => 2,
            'Email' => $this->data['Email'],
        ];
    }
}
