<?php

declare(strict_types=1);

namespace App\Bridge\DoctrineStorage;

use App\Entity\Hook;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Gateway\UserInterface;
use App\Repository\HookRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use App\Storage\StorageInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function findTransaction(?int $id, ?string $reference = null): Transaction
    {
        $transaction = null;

        if ($id > 0) {
            $transaction =  $this->transactionRepository->findOneBy(['id' => $id]);
        }

        if (false === is_null($reference)) {
            $transaction =  $this->transactionRepository->findOneBy(['reference' => $reference]);
        }

        if (false === $transaction instanceof Transaction) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        return $transaction;
    }

    public function saveTransaction(string $reference, string $type, array $data = []): Transaction
    {
        return $this->transactionRepository->save(
            (new Transaction())
                ->setReference($reference)
                ->setProcessorName(static::class)
                ->setType($type)
                ->setData($data)
        );
    }

    public function findHook(int $id): Hook
    {
        $hook = $this->hookRepository->find($id);

        if (false === $hook instanceof Hook) {
            throw new NotFoundHttpException('Hook not found.');
        }

        return $hook;
    }

    /**
     * @param string $processorName
     * @return Hook[]
     */
    public function findHooks(string $processorName): array
    {
        return $this->hookRepository->findBy(['processorName' => $processorName]);
    }

    public function findUser(int $id): User
    {
        $user = $this->userRepository->find($id);

        if (false === $user instanceof User) {
            throw new NotFoundHttpException('User not found.');
        }

        return $user;
    }

    public function findUserByEmail(string $email): User
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (false === $user instanceof User) {
            throw new NotFoundHttpException('User not found.');
        }

        return $user;
    }

    public function saveUser(UserInterface $user): User
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
        $hook = $this->hookRepository->find($id);

        return $this->hookRepository->save(
            $hook->setUrl($url)
                ->setStatus($status)
        );
    }
}
