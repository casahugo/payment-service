<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractGateway
{
    /** @var TransactionRepository  */
    protected $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFaker(): Generator
    {
        return Factory::create();
    }

    public function find(?int $id, ?string $reference = null): Transaction
    {
        $transaction = null;

        if ($id > 0) {
            $transaction =  $this->repository->findOneBy(['id' => $id]);
        }

        if (false === is_null($reference)) {
            $transaction =  $this->repository->findOneBy(['reference' => $reference]);
        }

        if (false === $transaction instanceof Transaction) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        return $transaction;
    }

    public function store(
        string $reference,
        string $type,
        array $data = []
    ): Transaction {
        return $this->repository->save(
            (new Transaction())
                ->setReference($reference)
                ->setProcessorName(static::class)
                ->setType($type)
                ->setData($data)
        );
    }
}
