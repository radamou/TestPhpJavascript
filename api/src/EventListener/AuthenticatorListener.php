<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthenticatorListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest',
                0,
            ],
        ];
    }

    /**
     * @throws \ErrorException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!str_contains($request->getRequestUri(), '/api/v1.0')) {
            return;
        }

        $authorizationHeader = $request->headers->get('X-AUTH-TOKEN');

        if (!$authorizationHeader) {
            throw new \Exception("Forbidden without Authentication header");
        }
    }
}