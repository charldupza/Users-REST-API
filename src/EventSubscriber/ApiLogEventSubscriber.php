<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\ApiLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiLogEventSubscriber implements EventSubscriberInterface
{
    private $em;
    public $request;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->request = $requestStack;

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['logCall', EventPriorities::POST_SERIALIZE],
        ];
    }

    public function logCall($event)
    {
        $log = new ApiLog;
        $log->setRequest($this->request->getCurrentRequest()->getRequestUri());
        $log->setMethod($this->request->getCurrentRequest()->getMethod());
        $log->setFormat($this->request->getCurrentRequest()->getRequestFormat());
        $log->setContent($this->request->getCurrentRequest()->getContent());
        $log->setResponse($event->getControllerResult());
        $log->setCreatedAt(new \DateTime());
        $this->saveCall($log);
    }

    private function saveCall($log)
    {
        $this->em->persist($log);
        $this->em->flush();
    }
}
