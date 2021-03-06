<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\ArrayableInterface;
use App\Gateway\Action\AbstractAction;
use App\Gateway\UserInterface;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseCreateUser;

class CreateUserAction extends AbstractAction
{
    /**
     * @param UserInterface $request
     * @return ArrayableInterface
     */
    public function execute($request)
    {
        try {
            $user = $this->storage->findUserByEmail($request->getEmail());
        } catch (\Throwable $exception) {
            $user = $this->storage->saveUser($request);
        }

        return new ResponseCreateUser($user);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof UserInterface && Mangopay::class === $class;
    }
}
