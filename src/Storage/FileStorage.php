<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Hook;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Gateway\UserInterface;
use Filebase\Database;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileStorage implements StorageInterface
{
    private const TRANSACTION = 'transaction';
    private const USER = 'user';
    private const WALLET = 'wallet';
    private const HOOK = 'hook';

    private function table(string $name): Database
    {
        return new Database([
            'dir' => '../var/database/' . $name
        ]);
    }

    public function findTransaction(?int $id, ?string $reference = null): Transaction
    {
        $transaction = null;

        if (\is_int($id)) {
            $transaction = $this->table(static::TRANSACTION)->get($id)->getData();
        }

        if (\is_string($reference)) {
            $transaction = current(
                $this->table(static::TRANSACTION)->query()->where(['reference' => $reference])->results()
            );
        }

        if (is_null($transaction) || false === \is_array($transaction)) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        return (new Transaction())
            ->setId($transaction['id'])
            ->setType($transaction['type'])
            ->setData($transaction['infos'])
            ->setReference($transaction['reference'])
            ;
    }

    public function saveTransaction(string $reference, string $type, array $data = []): Transaction
    {
        $transaction = (new Transaction())
            ->setId(rand())
            ->setReference($reference)
            ->setType($type)
            ->setProcessorName('')
            ->setData($data);

        $document = $this->table(static::TRANSACTION)->get($transaction->getId());

        $document->reference = $reference;
        $document->type = $transaction->getType();
        $document->id = $transaction->getId();
        $document->infos = $transaction->getData();
        $document->transaction = $transaction;
        $document->save();

        return $transaction;
    }

    public function findHook(int $id): Hook
    {
        $hook = $this->table(static::HOOK)->get($id);

        return (new Hook())
            ->setId($hook['id'])
            ->setProcessorName($hook['processorName'])
            ->setStatus($hook['status'])
            ->setUrl($hook['url'])
            ->setEvent($hook['event'])
            ;
    }

    public function findHooks(string $processorName): array
    {
        $hooks = $this->table(static::HOOK)->query()->where(['processorName' => $processorName])->results();

        return array_map(function ($hook): Hook {
            return (new Hook())
                ->setId($hook['id'])
                ->setProcessorName($hook['processorName'])
                ->setStatus($hook['status'])
                ->setUrl($hook['url'])
                ->setEvent($hook['event'])
                ;
        }, $hooks);
    }

    public function saveHook(string $url, string $status, string $event): Hook
    {
        $hook = (new Hook())
            ->setId(rand())
            ->setUrl($url)
            ->setStatus($status)
            ->setEvent($event)
            ;

        $document = $this->table(static::HOOK)->get($hook->getId());

        $document->id = $hook->getId();
        $document->url = $hook->getUrl();
        $document->status = $hook->getStatus();
        $document->processorName = $hook->getProcessorName();
        $document->event = $hook->getEvent();
        $document->save();

        return $hook;
    }

    public function updateHook(int $id, string $url, string $status): Hook
    {
        // TODO: Implement updateHook() method.
    }

    public function findUser(int $id): User
    {
        $user = $this->table(static::USER)->get($id)->getData();

        if (false === \is_array($user)) {
            throw new NotFoundHttpException('User ' . $id . ' not found');
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

    public function findUserByEmail(string $email): User
    {
        $users = $this->table(static::USER)->query()->where(['email' => $email])->results();
        $user = current($users);

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

    public function saveUser(UserInterface $user): User
    {
        $user = (new User())
            ->setId(rand())
            ->setEmail($user->getEmail())
            ->setFirstname($user->getFirstname())
            ->setLastname($user->getLastname())
            ;

        $document = $this->table(static::USER)->get($user->getId());
        $document->id = $user->getId();
        $document->email = $user->getEmail();
        $document->firstname = $user->getFirstname();
        $document->lastname = $user->getLastname();
        $document->processorName = 'processor';
        $document->mobile = '066789745';
        $document->city = 'Paris';
        $document->zipcode = '75001';
        $document->address = '';
        $document->birthday = '';
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
}
