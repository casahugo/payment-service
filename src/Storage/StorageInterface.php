<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Hook;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Gateway\UserInterface;

interface StorageInterface
{
    public function findTransaction(?int $id, ?string $reference = null): Transaction;

    public function saveTransaction(string $reference, string $type, array $data = []): Transaction;

    public function findHook(int $id): Hook;

    public function findHooks(string $processorName): array;

    public function saveHook(string $url, string $status, string $event): Hook;

    public function updateHook(int $id, string $url, string $status): Hook;

    public function findUser(int $id): User;

    public function findUserByEmail(string $email): User;

    public function saveUser(UserInterface $user): User;

    public function saveWallet(int $userId, string $currency, string $description = null): Wallet;

    public function findUserWallet(int $id): array;
}
