<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class UpdatedDateSubscriber implements EventSubscriberInterface
{

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * CurrentUserSubscriber constructor.
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [['setUpdatedDate', EventPriorities::PRE_WRITE]],
        ];
    }

    /**
     * Auto update updateDate from updated entities
     * @param GetResponseForControllerResultEvent $event
     */
    public function setUpdatedDate(GetResponseForControllerResultEvent $event)
    {
        $object = $event->getControllerResult();
        if (method_exists($object, 'setUpdatedDate'))
        {
            $object->setUpdatedDate();
        }
        $event->setControllerResult($object);
    }

}
