<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener
{

    /**
     * @ORM\PostPersist 
     */
    public function postPersistHandler(User $user, LifecycleEventArgs $event)
    {
        //Your function here
    }

}
