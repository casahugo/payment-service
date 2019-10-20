<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Capture;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseCapture;

class CaptureAction extends AbstractAction
{
    /**
     * @param Capture $request
     * @return ResponseCapture
     */
    public function execute($request)
    {
        $transaction = $this->storage->findTransaction(null, $request->getToken());

        return new ResponseCapture(
            $transaction->getData()['ReturnURL'],
            $transaction->getData()['ReturnURL'],
            $transaction->getId()
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Capture && Mangopay::class === $class;
    }
}
