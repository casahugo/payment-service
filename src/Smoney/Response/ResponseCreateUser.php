<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;
use App\Gateway\UserInterface;

class ResponseCreateUser implements ArrayableInterface
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
            'id' => $this->user->getId(),
            'AppUserId' => 'company-' . $this->user->getId(),
            'type' => 1,
            'role' => 1,
            'profile' => [
                'civility' => 0,
                'firstname' => $this->user->getFirstname(),
                'lastname' => $this->user->getLastname(),
                'birthdate' => '1985-09-29T00:00:00',
                'birthcity' => 'Las Vegas',
                'birthcountry' => 'US',
                'address' => [
                    'street' => '2 street',
                    'zipcode' => 'USA',
                    'city' => 'Las Vega',
                    'country' => 'US',
                ],
                'phonenumber' => '0600000001',
                'email' => $this->user->getEmail(),
                'alias' => $this->user->getFirstname() . ' ' . $this->user->getLastname(),
                'Picture' => [
                    'Href' => null,
                ],
                'ThirdPartyIntroduction' => 0,
            ],
            'Credentials' => null,
            'amount' => 0,
            'subaccounts' => [

            ],
            'bankaccounts' => null,
            'cbcards' => null,
            'status' => 1,
            'Company' => null
        ];
    }
}
