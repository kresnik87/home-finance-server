<?php

namespace App\EventListener;

use App\Entity\Home;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\NotificationUser;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class NotificationUserListener
{
    protected $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)

    {

        $this->tokenStorage = $tokenStorage;

    }

        /**
     * @ORM\PostUpdate
     */
    public function postUpdateHandler(NotificationUser $notificationUser, LifecycleEventArgs $event)
    {

        $em = $event->getEntityManager();
        if (is_null($this->tokenStorage->getToken()->getUser())) {
            return;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        if($notificationUser->getType()==NotificationUser::NOTIFICATION_TYPE_ANSWER&&$notificationUser->getAcepted()==true){
            $home=$notificationUser->getHome();
            if(!$home){
                throw new InvalidArgumentException("home.invalidHome");
            }
            $home->addMember($user);
            $em->persist($home);
            $em->flush();
        }

    }

}
