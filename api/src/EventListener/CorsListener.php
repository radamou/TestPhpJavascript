<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CorsListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                'onKernelResponse',
                0,
            ],
        ];
    }

    /**
     * @throws \ErrorException
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->add(
            [
                "Access-Control-Allow-Origin" => "*"
            ]
        );
    }
}