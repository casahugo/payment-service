<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Gateway\Lemonway;

use App\Entity\Transaction;
use App\Enum\PaymentType;
use App\Gateway\AbstractGateway;
use App\Gateway\GatewayName;
use App\Gateway\Lemonway\DTO\ResponseCreditCard;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;

final class Lemonway extends AbstractGateway
{
    /** @var TransactionRepository  */
    private $repository;

    /** @var LemonwayResolver  */
    private $resolver;

    /** @var \Faker\Generator  */
    private $faker;

    public const LOGIN = 'login';

    public const PASS = 'password';

    public function __construct(TransactionRepository $repository, LemonwayResolver $resolver)
    {
        $this->resolver = $resolver;
        $this->repository = $repository;
        $this->faker = $this->getFaker();
    }

    public function getResponseCreditCard(Request $request): ResponseCreditCard
    {
        $options = $this->resolver->resolveCreditCard($request->request->all());

        $transaction = $this->repository->save(
            (new Transaction())
                ->setReference($this->faker->md5)
                ->setProcessorName(GatewayName::LEMONWAY)
                ->setType(PaymentType::CREDITCARD)
                ->setData($options)
        );

        return new ResponseCreditCard(
            $transaction->getReference(),
            $transaction->getId(),
            (int) $options['registerCard'] === 1 ? $this->faker->randomNumber() : null
        );
    }

    public function checkToken(string $token)
    {
        $transaction = $this->repository->findOneBy(['token' => $token]);
    }
}