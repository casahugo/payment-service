<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonDecoderRequestEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(ControllerEvent $event): void
    {
        if (false === $event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (false === in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return;
        }

        if (
            'json' !== $request->getContentType()
            && 'application/vnd.s-money.v2+json' !== $request->headers->get('content-type')
        ) {
            return;
        }

        $data = json_decode(trim($request->getContent(), '\''), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }

        $request->request->replace(is_array($data) ? $data : []);
    }
}
