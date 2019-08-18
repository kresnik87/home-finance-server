<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Budget;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class BudgetListener
{
    protected $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)

    {

        $this->tokenStorage = $tokenStorage;

    }

        /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(Budget $budget, LifecycleEventArgs $event)
    {

        $em = $event->getEntityManager();
        if (is_null($this->tokenStorage->getToken()->getUser())) {
            return;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof User) {
           if($user->getHome()&& $user->getHome()->getOwner()->getId()==$user->getId()){
               $budget->setHome($user->getHome());
           }
            throw new InvalidArgumentException("home.notOwner");
        }
    }

}
