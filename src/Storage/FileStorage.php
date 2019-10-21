<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Hook;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Gateway\UserInterface;
use Filebase\Database;
use Filebase\Document;

class FileStorage implements StorageInterface
{
    private function table(string $name): Database
    {
        return new Database([
            'dir' => '../var/database/'.$name
        ]);
    }

    public function findTransaction(?int $id, ?string $reference = null): Transaction
    {
        if (is_int($id)) {
            $transaction = $this->table('transaction')->get($id);
        }

        if (is_int($reference)) {
            $transaction = current($this->table('transaction')->where(['reference' => $reference])->results());
        }

        return (new Transaction)
            ->setId($transaction->id)
            ->setType($transaction->type)
            ->setData($transaction->data)
            ->setReference($transaction->reference)
            ;
    }

    public function saveTransaction(string $reference, string $type, array $data = []): Transaction
    {
        $transaction = (new Transaction())
            ->setId(rand())
            ->setReference($reference)
            ->setType($type)
            ->setData($data);

        $document = $this->table('transaction')->get($transaction->getId());

        $document->reference = $reference;
        $document->type = $transaction->getType();
        $document->id = $transaction->getId();
        $document->data = $transaction->getData();
        $document->transaction = $transaction;
        $document->save();

        return $transaction;
    }

    public function findHook(int $id): Hook
    {
        // TODO: Implement findHook() method.
    }

    public function findHooks(string $processorName): array
    {
        // TODO: Implement findHooks() method.
    }

    public function saveHook(string $url, string $status, string $event): Hook
    {
        // TODO: Implement saveHook() method.
    }

    public function updateHook(int $id, string $url, string $status): Hook
    {
        // TODO: Implement updateHook() method.
    }

    public function findUser(int $id): User
    {
        // TODO: Implement findUser() method.
    }

    public function findUserByEmail(string $email): User
    {
        // TODO: Implement findUserByEmail() method.
    }

    public function saveUser(UserInterface $user): User
    {
        // TODO: Implement saveUser() method.
    }

    public function saveWallet(int $userId, string $currency, string $description = null): Wallet
    {
        // TODO: Implement saveWallet() method.
    }

    public function findUserWallet(int $id): array
    {
        // TODO: Implement findUserWallet() method.
    }
}
