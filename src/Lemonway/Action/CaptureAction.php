<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

use App\Enum\HookEvent;
use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Capture;
use App\Lemonway\Lemonway;
use App\Lemonway\Response\ResponseCapture;

class CaptureAction extends AbstractAction
{
    /**
     * @param Capture $request
     * @return ResponseCapture
     */
    public function execute($request): ResponseCapture
    {
        $response = new ResponseCapture($request->getTransaction(), $request->hasErrors());

        $this->storage->saveHook(
            (string) $response->getCallback(),
            'SUCCES',
            HookEvent::PAYMENT_NOTIFICATION,
            Lemonway::class,
            $response->toArray()
        );

        return $response;
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Capture && Lemonway::class === $class;
    }
}
