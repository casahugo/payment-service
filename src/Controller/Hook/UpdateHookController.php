<?php

declare(strict_types=1);

namespace App\Controller\Hook;

use App\Mangopay\Response\ResponseHook;
use App\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;

class UpdateHookController
{
    public function __invoke(int $hookId, Storage $storage, Request $request)
    {
        $hook = $storage->updateHook(
            $hookId,
            $request->request->get('Url'),
            $request->request->get('Status')
        );

        return new ResponseHook($hook);
    }
}
