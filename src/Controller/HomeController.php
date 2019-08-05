<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Home;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Vich\UploaderBundle\Storage\StorageInterface;
use App\Service\NotificationGenerator;
use App\Helpers\ObjectUtils;

class HomeController extends Controller
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var NotificationGenerator
     */
    protected $notificationGenerator;

    /**
     * @var ObjectUtils
     */
    protected $objUtils;

    public function __construct(StorageInterface $storage, NotificationGenerator $notif, ObjectUtils $objUtils)
    {
        $this->storage = $storage;
        $this->notificationGenerator = $notif;
        $this->objUtils = $objUtils;
    }


    public function sendRequestHomeMembersAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);
        $user=$this->getUser();
        die(var_dump($user->getHome()->getId()));
        if (!$params || !count($params) || !isset($params["members"]))
        {
            throw new InvalidArgumentException("Needs params to add to Home");
        }
        if(is_null($user->getHome())){
            throw  new InvalidArgumentException("Not have Home");
        }
        $home=$user->getHome();
        if($home->getOwner()->getId()!=$user->getId()){
            throw  new InvalidArgumentException("User is not Owner");
        }

        $members=new ArrayCollection();
        foreach ($params["members"] as $item){
            if($this->getDoctrine()->getRepository(Home::class)->findBy(["email"=>$item])){
                $members[]=$this->getDoctrine()->getRepository(Home::class)->findBy(["email"=>$item]);
                var_dump($members);
            }else{
                throw  new InvalidArgumentException($item." this user not exist");
            }
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();
        return $user;
    }


}
