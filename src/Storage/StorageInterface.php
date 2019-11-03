<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Hook;
use App\Entity\Wallet;
use App\Gateway\TransactionInterface;
use App\Gateway\UserInterface;

interface StorageInterface
{
    /**
     * @return TransactionInterface[]
     */
    public function findTransactions(): array;

    /**
     * @return UserInterface[]
     */
    public function findUsers(): array;

    public function findTransaction(?int $id, ?string $reference = null): ?TransactionInterface;

    public function saveTransaction(
        string $reference,
        string $processor,
        string $type,
        array $data = []
    ): TransactionInterface;

    public function findHook(int $id): ?Hook;

    public function findHooks(string $processorName): array;

    public function saveHook(string $url, string $status, string $event): Hook;

    public function updateHook(int $id, string $url, string $status): Hook;

    public function findUser(int $id): ?UserInterface;

    public function findUserByEmail(string $email): ?UserInterface;

    public function saveUser(UserInterface $user): UserInterface;

    public function saveWallet(int $userId, string $currency, string $description = null): Wallet;

    public function findUserWallet(int $id): array;
}
