<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

use App\Gateway\Action\ActionInterface;
use App\Gateway\Request\Capture;
use App\Lemonway\Lemonway;
use App\Lemonway\Response\ResponseCapture;

class CaptureAction implements ActionInterface
{
    /**
     * @param Capture $request
     * @return ResponseCapture
     */
    public function execute($request): ResponseCapture
    {
        return new ResponseCapture($request->getTransaction(), $request->hasErrors());
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Capture && Lemonway::class === $class;
    }
}
