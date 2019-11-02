<?php

declare(strict_types=1);

namespace App\Mangopay\Response;

use App\ArrayableInterface;
use App\Gateway\UserInterface;

class ResponseUser implements ArrayableInterface
{
    /** @var UserInterface  */
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return [
            'HeadquartersAddress' => [
                'AddressLine1' => '1 Mangopay Street',
                'AddressLine2' => 'The Loop',
                'City' => 'Paris',
                'Region' => 'Ile de France',
                'PostalCode' => '75001',
                'Country' => 'FR',
            ],
            'LegalRepresentativeAddress' => [
                'AddressLine1' => '1 Mangopay Street',
                'AddressLine2' => 'The Loop',
                'City' => 'Paris',
                'Region' => 'Ile de France',
                'PostalCode' => '75001',
                'Country' => 'FR',
            ],
            'Name' => 'Mangopay Ltd',
            'LegalPersonType' => 'BUSINESS',
            'LegalRepresentativeFirstName' => $this->user->getFirstname(),
            'LegalRepresentativeLastName' => $this->user->getLastname(),
            'LegalRepresentativeEmail' => $this->user->getEmail(),
            'LegalRepresentativeBirthday' => '1463496101',
            'LegalRepresentativeNationality' => 'FR',
            'LegalRepresentativeCountryOfResidence' => 'ES',
            'ProofOfRegistration' => '',
            'ShareholderDeclaration' => '',
            'Statute' => '',
            'LegalRepresentativeProofOfIdentity' => '',
            'CompanyNumber' => 'LU72HN11',
            'PersonType' => 'LEGAL',
            'Email' => $this->user->getEmail(),
            'KYCLevel' => 'LIGHT',
            'Id' => $this->user->getId(),
            'Tag' => 'custom meta',
            'CreationDate' => '1442181882',
        ];
    }
}
