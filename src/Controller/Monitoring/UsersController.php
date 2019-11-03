<?php

declare(strict_types=1);

namespace App\Controller\Monitoring;

use App\Entity\User;
use App\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController
{
    public function __invoke(StorageInterface $storage): JsonResponse
    {
        return new JsonResponse([
            'items' => array_map(function (User $user): array {
                return [
                    'id' => $user->getId(),
                    'lastname' => $user->getLastname(),
                    'firstname' => $user->getFirstname(),
                    'email' => $user->getEmail(),
                    'processorName' => $user->getProcessorName(),
                    'active' => false,
                ];
            }, $storage->findUsers())
        ]);
    }
}
