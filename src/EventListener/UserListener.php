<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\FinanceStatus;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener
{

    /**
     * @ORM\PostUpdate
     */
    public function postUpdateHandler(User $user, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();

        if(is_null($user->getFinanceStatus())){
            $this->createFinanceStatus($user,$em);
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(User $user, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        if(is_null($user->getFinanceStatus())){
            $this->createFinanceStatus($user,$em);
        }
    }


    public function createFinanceStatus(User $user, $em){
        $financeStatus = new FinanceStatus();
        $financeStatus->setAmount(0);
        $financeStatus->setUser($user);
        $em->persist($financeStatus);
    }

}
