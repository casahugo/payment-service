<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Capture;
use App\Smoney\Response\ResponseCapture;
use App\Smoney\Smoney;

class CaptureAction extends AbstractAction
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
        return $request instanceof Capture && Smoney::class === $class;
    }
}
