<?php

declare(strict_types=1);

namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;

class PublishRequestEventSubscriber implements EventSubscriberInterface
{
    /** @var Publisher  */
    private $publisher;

    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(KernelEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $event->isMasterRequest() or false === $request->attributes->has('gatewayName')) {
            return;
        }

        call_user_func($this->publisher, new Update(
            'request',
            json_encode([
                'method' => $request->getMethod(),
                'uri' => $request->getRequestUri(),
                'gateway' => $request->attributes->get('gatewayName'),
                'params' => [
                    //'headers' => $request->headers->all(),
                    'request' => $request->request->all(),
                    'query' => $request->query->all(),
                ],
            ])
        ));
    }
}
