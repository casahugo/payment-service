<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\ArrayableInterface;
use App\Gateway\Action\AbstractAction;
use App\Gateway\UserInterface;
use App\Smoney\Response\ResponseCreateUser;
use App\Smoney\Smoney;

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
        return $request instanceof UserInterface && Smoney::class === $class && is_null($request->getId());
    }
}
