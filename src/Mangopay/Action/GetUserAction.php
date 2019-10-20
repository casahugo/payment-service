<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\User;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseUser;

class GetUserAction extends AbstractAction
{
    /**
     * @param User $request
     * @return ResponseUser
     */
    public function execute($request)
    {
        $user = $this->storage->findUser($request->getId());

        return new ResponseUser($user->getId(), $user);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof User &&
            false === is_null($request->getId()) &&
            Mangopay::class === $class;
    }
}
