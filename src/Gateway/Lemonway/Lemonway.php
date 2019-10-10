<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Gateway\Lemonway;

use Symfony\Component\HttpFoundation\Request;

final class Lemonway extends AbstractGateway
{
    /** @var LemonwayResolver  */
    private $resolver;

    public const LOGIN = 'login';

    public const PASS = 'password';

    public function __construct(LemonwayResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function getResponseCreditCard(Request $request): array
    {
        $options = $this->resolver->resolveCreditCard($request->request->all());
        $faker = $this->getFaker();


        return [
            'MONEYINWEB' => [
                'TOKEN' => $faker->md5,
                'ID' => $faker->randomNumber(),
                'CARD' => [
                    'ID' => (int) $options['registerCard'] === 1 ? $faker->randomNumber() : null,
                ],
                'REDIRECTURL'
            ],
        ];
    }
}