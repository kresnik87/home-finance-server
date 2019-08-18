<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\BudgetCat;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class BudgetCatListener
{
    protected $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)

    {

        $this->tokenStorage = $tokenStorage;

    }

        /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(BudgetCat $budgetCat, LifecycleEventArgs $event)
    {

        $em = $event->getEntityManager();
        if (is_null($this->tokenStorage->getToken()->getUser())) {
            return;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof User) {
           if($user->getHome()&&$user->getHome()->isUserOwner($user)){
               $start=$budgetCat->getStartDate()->format("Y-m-d");
               $endDate= (new \DateTime($start))->modify($budgetCat->getFrecuencyToTime());
               $budgetCat->setEndDate($endDate);
           }
            throw new InvalidArgumentException("home.notOwner");
        }
    }

}
