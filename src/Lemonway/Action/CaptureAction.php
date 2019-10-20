<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

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
    public function execute($request)
    {
        $transaction = $this->storage->findTransaction(null, $request->getToken());

        $return = $request->hasErrors() ? $transaction->getData()['errorUrl'] : $transaction->getData()['returnUrl'];

        return new ResponseCapture($return, $transaction->getId(), $transaction->getReference());
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Capture && Lemonway::class === $class;
    }
}
