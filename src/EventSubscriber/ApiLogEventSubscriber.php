<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\ApiLog;
use App\Service\ApiLogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiLogEventSubscriber implements EventSubscriberInterface
{
    private $em;
    public $request;

    // Invoke Our Service
    public function __construct(RequestStack $requestStack, ApiLogService $em)
    {
        $this->request = $requestStack;
        $this->em = $em;

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['logCall', EventPriorities::POST_SERIALIZE],
        ];
    }

    // Create Log Object
    public function logCall($event)
    {
        $log = new ApiLog;
        $log->setRequest($this->request->getCurrentRequest()->getRequestUri());
        $log->setMethod($this->request->getCurrentRequest()->getMethod());
        $log->setFormat($this->request->getCurrentRequest()->getRequestFormat());
        $log->setContent($this->request->getCurrentRequest()->getContent());
        $log->setResponse($event->getControllerResult());
        $log->setCreatedAt(new \DateTime());
        $this->em->saveCall($log); // Send To Service
    }
}
