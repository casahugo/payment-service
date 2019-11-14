<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
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
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelRequest(KernelEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $event->isMasterRequest() or false === $request->attributes->has('gatewayName')) {
            return;
        }

        $this->publish($request, [
            'request' => $request->request->all(),
            'query' => $request->query->all(),
        ]);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if (false === $event->isMasterRequest() or false === $request->attributes->has('gatewayName')) {
            return;
        }

        $content = json_decode(is_string($response->getContent()) ? $response->getContent() : '', true);

        if (false === \is_array($content)) {
            return;
        }

        $this->publish($request, $content);
    }

    private function publish(Request $request, array $data = []): void
    {
        call_user_func($this->publisher, new Update(
            'request',
            json_encode([
                'method' => $request->getMethod(),
                'uri' => $request->getRequestUri(),
                'gateway' => $request->attributes->get('gatewayName'),
                'params' => $data,
            ], JSON_THROW_ON_ERROR)
        ));
    }
}
