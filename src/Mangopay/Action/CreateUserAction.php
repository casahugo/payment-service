<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\User;
use App\Gateway\UserInterface;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseCreateUser;

class CreateUserAction extends AbstractAction
{
    /**
     * @param User $request
     * @return ResponseCreateUser
     */
    public function execute($request)
    {
        try {
            $user = $this->storage->findUserByEmail($request->getEmail());
        } catch (\Throwable $exception) {
            $user = $this->storage->saveUser($request->getData());
        }

        return new ResponseCreateUser($user->getId(), $user);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof User &&
            $request->getData() instanceof UserInterface &&
            Mangopay::class === $class;
    }
}
