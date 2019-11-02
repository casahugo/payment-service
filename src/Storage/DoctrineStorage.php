<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Hook;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Gateway\TransactionInterface;
use App\Gateway\UserInterface;
use App\Repository\HookRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;

class DoctrineStorage implements StorageInterface
{
    /** @var TransactionRepository  */
    protected $transactionRepository;

    /** @var UserRepository  */
    private $userRepository;

    /** @var WalletRepository  */
    private $walletRepository;

    /** @var HookRepository  */
    private $hookRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        UserRepository $userRepository,
        WalletRepository $walletRepository,
        HookRepository $hookRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->hookRepository = $hookRepository;
        $this->walletRepository = $walletRepository;
    }

    public function findTransaction(?int $id, ?string $reference = null): ?TransactionInterface
    {
        if ($id > 0) {
            return $this->transactionRepository->findOneBy(['id' => $id]);
        }

        if (false === is_null($reference)) {
            return $this->transactionRepository->findOneBy(['reference' => $reference]);
        }

        return null;
    }

    public function saveTransaction(
        string $reference,
        string $processor,
        string $type,
        array $data = []
    ): TransactionInterface {
        return $this->transactionRepository->save(
            (new Transaction())
                ->setReference($reference)
                ->setProcessorName($processor)
                ->setType($type)
                ->setData($data)
        );
    }

    public function findHook(int $id): ?Hook
    {
        return $this->hookRepository->find($id);
    }

    /**
     * @param string $processorName
     * @return Hook[]
     */
    public function findHooks(string $processorName): array
    {
        return $this->hookRepository->findBy(['processorName' => $processorName]);
    }

    public function findUser(int $id): ?UserInterface
    {
        return $this->userRepository->find($id);
    }

    public function findUserByEmail(string $email): ?UserInterface
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function saveUser(UserInterface $user): UserInterface
    {
        return $this->userRepository->save(
            (new User())
                ->setEmail($user->getEmail())
                ->setFirstname($user->getFirstname())
                ->setLastname($user->getFirstname())
                ->setCity('Paris')
                ->setZipcode('75001')
                ->setCountry('FR')
                ->setBirthday('1463496101')
                ->setMobile('+33771123552')
                ->setProcessorName(static::class)
        );
    }

    public function saveWallet(int $userId, string $currency, string $description = null): Wallet
    {
        return $this->walletRepository->save(
            (new Wallet())
                ->setUserId($userId)
                ->setCurrency($currency)
                ->setDescription($description)
        );
    }

    /**
     * @param int $id
     * @return Wallet[]
     */
    public function findUserWallet(int $id): array
    {
        return $this->walletRepository->findBy(['user_id' => $id]);
    }

    public function saveHook(string $url, string $status, string $event): Hook
    {
        return $this->hookRepository->save(
            (new Hook())
                ->setUrl($url)
                ->setStatus($status)
                ->setEvent($event)
                ->setProcessorName(static::class)
        );
    }

    public function updateHook(int $id, string $url, string $status): Hook
    {
        return $this->hookRepository->save(
            $this->hookRepository
                ->find($id)
                ->setUrl($url)
                ->setStatus($status)
        );
    }
}
