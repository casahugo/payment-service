<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\ActionInterface;
use App\Gateway\Request\Capture;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseCapture;

class CaptureAction implements ActionInterface
{
    /**
     * @param Capture $request
     * @return ResponseCapture
     */
    public function execute($request)
    {
        return new ResponseCapture($request->getTransaction(), $request->hasErrors());
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Capture && Mangopay::class === $class;
    }
}
