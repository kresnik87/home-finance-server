<?php

namespace App\EventSubscriber;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\User;

class CurrentUserSubscriber implements EventSubscriber
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

    public function getSubscribedEvents()
    {
        return [Events::prePersist];
    }

    /*
     *   If entity has user attribute, sets current user 
     */

    public function prePersist(LifecycleEventArgs $event)
    {
        $object = $event->getObject();
        if (method_exists($object, 'setUser') && $this->tokenStorage->getToken())
        {
            if ($this->tokenStorage->getToken()->getUser() instanceof User)
            {
                $object->setUser($this->tokenStorage->getToken()->getUser());
            }
        }
    }

}
