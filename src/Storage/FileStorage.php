<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Hook;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Gateway\TransactionInterface;
use App\Gateway\UserInterface;
use Filebase\Database;
use Filebase\Document;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;

class FileStorage implements StorageInterface
{
    private const TRANSACTION = 'transaction';
    private const USER = 'user';
    private const WALLET = 'wallet';
    private const HOOK = 'hook';

    /** @var Publisher  */
    private $publisher;

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function findTransactions(): array
    {
        return \array_map(function (Document $transaction): TransactionInterface {
            return (new Transaction())
                ->setId($transaction->getData()['id'])
                ->setType($transaction->getData()['type'])
                ->setProcessorName($transaction->getData()['processorName'])
                ->setData($transaction->getData()['extra'])
                ->setReference($transaction->getData()['reference'])
                ->setCreatedAt(new \DateTime($transaction->createdAt()))
                ->setUpdatedAt(new \DateTime($transaction->updatedAt()))
                ;
        }, $this->table(static::TRANSACTION)
            ->query()
            ->orderBy('__created_at', 'DESC')
            ->resultDocuments()
        );
    }

    public function findTransaction(?int $id, ?string $reference = null): ?TransactionInterface
    {
        $transaction = null;

        if (\is_int($id)) {
            $transaction = $this->table(static::TRANSACTION)->get($id)->getData();
        }

        if (\is_null($transaction) && \is_string($reference)) {
            $transaction = current(
                $this->table(static::TRANSACTION)->query()->where(['reference' => $reference])->results()
            );
        }

        return (new Transaction())
            ->setId($transaction['id'])
            ->setType($transaction['type'])
            ->setProcessorName($transaction['processorName'])
            ->setData($transaction['extra'])
            ->setReference($transaction['reference'])
           // ->setCreatedAt($transaction['createdAt'])
           // ->setUpdatedAt($transaction['updatedAt'])
            ;
    }

    public function saveTransaction(
        string $reference,
        string $processor,
        string $type,
        array $data = []
    ): TransactionInterface {
        $transaction = (new Transaction())
            ->setId(rand())
            ->setReference($reference)
            ->setType($type)
            ->setProcessorName($processor)
            ->setData($data)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ;

        $document = $this->table(static::TRANSACTION)->get($transaction->getId());

        $document->reference = $reference;
        $document->type = $transaction->getType();
        $document->processorName = $transaction->getProcessorName();
        $document->id = $transaction->getId();
        $document->extra = $transaction->getData();

        $document->save();

        $this->publish(static::TRANSACTION, $transaction->toArray());

        return $transaction;
    }

    public function findHook(int $id): ?Hook
    {
        $hook = $this->table(static::HOOK)->get($id);

        if (false === $hook['id']) {
            return null;
        }

        return (new Hook())
            ->setId($hook['id'])
            ->setProcessorName($hook['processorName'])
            ->setStatus($hook['status'])
            ->setUrl($hook['url'])
            ->setEvent($hook['event'])
            ;
    }

    public function findHooks(string $processorName = null, string $event = null): array
    {
        $query = $this
            ->table(static::HOOK)
            ->query()
            ->orderBy('__created_at', 'DESC')
            ;

        if (\is_string($processorName)) {
            $query->where(['processorName' => $processorName]);
        }

        if (\is_string($event)) {
            $query->where(['event' => $event]);
        }

        return \array_map(function (Document $hook): Hook {
            return (new Hook())
                ->setId($hook->getData()['id'])
                ->setProcessorName($hook->getData()['processorName'])
                ->setStatus($hook->getData()['status'])
                ->setUrl($hook->getData()['url'])
                ->setEvent($hook->getData()['event'])
                ->setData($hook->getData()['extra'])
                ;
        }, $query->resultDocuments());
    }

    public function saveHook(
        string $url,
        string $status,
        string $event,
        string $processor,
        array $data = []
    ): Hook {
        $hook = (new Hook())
            ->setId(rand())
            ->setUrl($url)
            ->setProcessorName($processor)
            ->setStatus($status)
            ->setEvent($event)
            ->setData($data);
            ;

        $document = $this->table(static::HOOK)->get($hook->getId());

        $document->id = $hook->getId();
        $document->url = $hook->getUrl();
        $document->status = $hook->getStatus();
        $document->processorName = $hook->getProcessorName();
        $document->event = $hook->getEvent();
        $document->extra = $hook->getData();
        $document->save();

        $this->publish(static::HOOK, $hook->toArray());

        return $hook;
    }

    public function updateHook(int $id, string $url, string $status): Hook
    {
        // TODO: Implement updateHook() method.
    }

    /**
     * @return UserInterface[]
     */
    public function findUsers(): array
    {
        return array_map(function ($user): UserInterface {
            return (new User())
                ->setId($user->id)
                ->setFirstname($user->firstname)
                ->setLastname($user->lastname)
                ->setEmail($user->email)
                ->setProcessorName($user->processorName)
                ;
        }, $this->table(static::USER)->findAll());
    }

    public function findUser(int $id): ?UserInterface
    {
        $user = $this->table(static::USER)->get($id)->getData();

        if (false === \array_key_exists('id', $user)) {
            return null;
        }

        return (new User())
            ->setId($user['id'])
            ->setEmail($user['email'])
            ->setProcessorName($user['processorName'])
            ->setFirstname($user['firstname'])
            ->setLastname($user['lastname'])
            ->setMobile($user['mobile'])
            ->setCity($user['city'])
            ->setZipcode($user['zipcode'])
            ->setAddress($user['address'])
            ->setBirthday($user['birthday'])
            ;
    }

    public function findUserByEmail(string $email): ?UserInterface
    {
        $users = $this->table(static::USER)->query()->where(['email' => $email])->results();
        $user = current($users);

        if (is_null($user)) {
            return null;
        }

        return (new User())
            ->setId($user['id'])
            ->setEmail($user['email'])
            ->setProcessorName($user['processorName'])
            ->setFirstname($user['firstname'])
            ->setLastname($user['lastname'])
            ->setMobile($user['mobile'])
            ->setCity($user['city'])
            ->setZipcode($user['zipcode'])
            ->setAddress($user['address'])
            ->setBirthday($user['birthday'])
            ;
    }

    public function saveUser(UserInterface $user): UserInterface
    {
        if (false === $user instanceof User) {
            $user = (new User())
                ->setId($user->getId() ?? rand())
                ->setEmail($user->getEmail())
                ->setFirstname($user->getFirstname())
                ->setLastname($user->getLastname())
                ->setProcessorName('')
                ->setMobile('')
                ->setCity('')
                ->setZipcode('')
                ->setAddress('')
                ->setBirthday('')
            ;
        }

        $document = $this->table(static::USER)->get($user->getId());
        $document->id = $user->getId();
        $document->email = $user->getEmail();
        $document->firstname = $user->getFirstname();
        $document->lastname = $user->getLastname();
        $document->processorName = $user->getProcessorName();
        $document->mobile = $user->getMobile();
        $document->city = $user->getCity();
        $document->zipcode = $user->getZipcode();
        $document->address = $user->getAddress();
        $document->birthday = $user->getBirthday();
        $document->save();

        return $user;
    }

    public function saveWallet(int $userId, string $currency, string $description = null): Wallet
    {
        $wallet = (new Wallet())
            ->setId(rand())
            ->setUserId($userId)
            ->setCurrency($currency)
            ->setDescription($description)
        ;

        $document = $this->table(static::WALLET)->get($wallet->getId());
        $document->id = $wallet->getId();
        $document->userId = $wallet->getUserId();
        $document->currency = $wallet->getCurrency();
        $document->description = $wallet->getDescription();
        $document->save();

        return $wallet;
    }

    public function findUserWallet(int $id): array
    {
        $wallets = $this->table(static::WALLET)->query()->where(['userId' => $id])->results();

        return array_map(function ($wallet): Wallet {
            return (new Wallet())
                ->setId($wallet['id'])
                ->setUserId($wallet['userId'])
                ->setCurrency($wallet['currency'])
                ->setDescription($wallet['description'])
                ;
        }, $wallets);
    }

    private function publish(string $name, array $data): self
    {
        call_user_func(
            $this->publisher,
            new Update($name, json_encode(['data' => $data], JSON_THROW_ON_ERROR))
        );

        return $this;
    }

    private function table(string $name): Database
    {
        return new Database([
            'dir' => '../var/database/' . $name
        ]);
    }
}
