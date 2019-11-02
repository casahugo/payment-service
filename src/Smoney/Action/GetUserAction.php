<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\Entity\User;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\User as UserRequest;
use App\Smoney\Response\ResponseUser;
use App\Smoney\Smoney;
use Faker\Factory;

class GetUserAction extends AbstractAction
{
    /**
     * @param UserRequest $request
     * @return ResponseUser
     */
    public function execute($request)
    {
        $user = $this->storage->findUser($request->getId());

        if (\is_null($user)) {
            $user = $this->storage->saveUser(
                (new User())
                    ->setId($request->getId())
                    ->setProcessorName(Smoney::class)
                    ->setFirstname(Factory::create()->firstName)
                    ->setLastname(Factory::create()->lastName)
                    ->setBirthday(Factory::create()->date())
                    ->setEmail(Factory::create()->email)
                    ->setAddress(Factory::create()->address)
                    ->setZipcode(Factory::create()->postcode)
                    ->setCity(Factory::create()->city)
                    ->setCountry(Factory::create()->country)
                    ->setMobile(Factory::create()->phoneNumber)
            );
        }

        return new ResponseUser($user);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof UserRequest && $request->hasId() && Smoney::class === $class;
    }
}
