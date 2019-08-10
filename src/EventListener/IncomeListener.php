<?php

namespace App\EventListener;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Income;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class IncomeListener
{
    protected $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)

    {

        $this->tokenStorage = $tokenStorage;

    }

        /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(Income $income, LifecycleEventArgs $event)
    {

        $em = $event->getEntityManager();
        if (is_null($this->tokenStorage->getToken()->getUser())) {
            return;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof User && $user->getFinanceStatus()!=null) {
            $income->setFinanceStatus($user->getFinanceStatus());
        }
    }

}
