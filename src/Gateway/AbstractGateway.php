<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Gateway\Action\ActionInterface;
use App\Gateway\Request\Capture;
use App\Gateway\Request\Checkout;
use App\Gateway\Request\Transaction;
use App\Storage\StorageInterface;
use App\Storage\StorageAwareInterface;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractGateway implements GatewayInterface
{
    /** @var StorageInterface  */
    private $storage;

    /** @var RouterInterface  */
    private $router;

    /** @var array  */
    private $actions = [];

    public function __construct(iterable $actions, StorageInterface $storage, RouterInterface $router)
    {
        $this->setActions($actions);
        $this->storage = $storage;
        $this->router = $router;
    }

    public function execute($request)
    {
        /** @var ActionInterface $action */
        foreach ($this->actions as $action) {
            if ($action->supports($request, static::class)) {
                if ($request instanceof Capture or $request instanceof Checkout) {
                    $request->setTransaction(
                        $this->storage->findTransaction($request->getId(), $request->getReference())
                    );
                }

                if ($request instanceof Transaction) {
                    $request = $this->storage->findTransaction($request->getId(), $request->getReference());
                }

                if ($action instanceof StorageAwareInterface) {
                    $action->setStorage($this->storage);
                }

                if ($action instanceof RouterAwareInterface) {
                    $action->setRouter($this->router);
                }

                return $action->execute($request);
            }
        }

        throw new \LogicException('Unable to find supported action.');
    }

    public function setActions(iterable $actions): void
    {
        foreach ($actions as $action) {
            $this->actions[] = $action;
        }
    }
}
