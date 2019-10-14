<?php

declare(strict_types=1);

namespace App\Mangopay;

use App\Entity\Wallet;
use App\Enum\PaymentType;
use App\Gateway\AbstractGateway;
use App\Gateway\GatewayInterface;
use App\Gateway\TransactionInterface;
use App\Gateway\UserInterface;
use App\Mangopay\DTO\RequestCreditCardPayment;
use App\Mangopay\DTO\ResponseCreateUser;
use App\Mangopay\DTO\ResponseCreditCard;
use App\Mangopay\DTO\ResponseTransactionDetails;
use App\Mangopay\DTO\ResponseUser;
use App\Mangopay\DTO\ResponseWallet;
use App\Mangopay\DTO\ResponseWallets;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class Mangopay extends AbstractGateway implements GatewayInterface
{
    public function prepareCreditCard(array $data)
    {
        $transaction = $this->getStorage()->saveTransaction($this->getFaker()->md5, PaymentType::CREDITCARD, $data);

        return new ResponseCreditCard(
            $transaction->getId(),
            $this->getRouter()->generate('mangopay_checkout', [
                'transactionId' => $transaction->getId()
            ], RouterInterface::ABSOLUTE_URL),
            $data
        );
    }

    public function getRequestCreditCardPayment(string $token, int $error = 0)
    {
        $transaction = $this->getStorage()->findTransaction((int) $token);

        return new RequestCreditCardPayment(
            $transaction->getData()['ReturnURL'],
            $transaction->getData()['ReturnURL'],
            $transaction->getId()
        );
    }

    public function getTransactionDetails(TransactionInterface $transactionDetails)
    {
        $transaction = $this->getStorage()->findTransaction($transactionDetails->getId());

        return new ResponseTransactionDetails($transaction->getId(), $transaction->getData());
    }

    public function getUser(int $id)
    {
        $user = $this->getStorage()->findUser($id);

        return new ResponseUser($user->getId(), $user);
    }

    public function getUserWallet(int $userId)
    {
        $wallets = $this->getStorage()->findUserWallet($userId);

        return new ResponseWallets(array_map(function (Wallet $wallet): ResponseWallet {
            return new ResponseWallet($wallet);
        }, $wallets));
    }

    public function createUserWallet(int $userId, string $currency, string $description = null)
    {
        return new ResponseWallet($this->getStorage()->saveWallet($userId, $currency, $description));
    }

    public function createUser(UserInterface $createUser)
    {
        try {
            $user = $this->getStorage()->findUserByEmail($createUser->getEmail());
        } catch (NotFoundHttpException $exception) {
            $user = $this->getStorage()->saveUser($createUser);
        }

        return new ResponseCreateUser($user->getId(), $user);
    }
}
