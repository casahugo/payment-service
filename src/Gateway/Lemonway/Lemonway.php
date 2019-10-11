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
use App\Gateway\GatewayInterface;
use App\Gateway\GatewayName;
use App\Gateway\Lemonway\DTO\ResponseCreditCard;
use App\Gateway\Lemonway\DTO\RequestCreditCardPayment;
use App\Gateway\Lemonway\DTO\ResponseTransactionDetails;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;

final class Lemonway extends AbstractGateway implements GatewayInterface
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

    public function getResponseInitCreditCard(Request $request): ResponseCreditCard
    {
        $options = $this->resolver->resolveCreditCard($request->request->get('p'));

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

    public function getResponseCreditCardPayment(string $token, int $erreur = 0): RequestCreditCardPayment
    {
        $transaction = $this->repository->findOneBy(['reference' => $token]);
        $data = $transaction->getData();

        if ($erreur === 1) {
            return new RequestCreditCardPayment($data['errorUrl'], $transaction->getId(), $transaction->getReference());
        }

        return new RequestCreditCardPayment($data['returnUrl'], $transaction->getId(), $transaction->getReference());
    }

    public function getTransactionDetails(Request $request): ?ResponseTransactionDetails
    {
        $options = $this->resolver->resolveTransactionDetails($request->request->get('p'));
        $transaction = null;

        if (array_key_exists('transactionId', $options) && $options['transactionId'] > 0) {
            $transaction = $this->repository->findOneBy(['id' => $options['transactionId']]);
        }

        if (is_string($options['transactionMerchantToken']) && mb_strlen($options['transactionMerchantToken']) > 0) {
            $transaction = $this->repository->findOneBy(['reference' => $options['transactionMerchantToken']]);
        }

        if ($transaction instanceof Transaction) {
            $data =  $transaction->getData();

            return new ResponseTransactionDetails(
                $transaction->getId(),
                $data['wallet'],
                (float) $data['amountTot'],
                $data['comment']
            );
        }
    }

    public function verifyToken(string $token): bool
    {
        $transaction = $this->repository->findOneBy(['reference' => $token]);

        return $transaction instanceof Transaction;
    }
}