<?php

namespace App\Controller;

use App\Entity\NotificationUser;
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
        $user = $this->getUser();
        if (!$params || !count($params) || !isset($params["member"])) {
            throw new InvalidArgumentException("Needs params to add to Home");
        }
        if (is_null($user->getHome())) {
            throw  new InvalidArgumentException("Not have Home");
        }
        $home = $user->getHome();
        if ($home->getOwner()->getId() != $user->getId()) {
            throw  new InvalidArgumentException("User is not Owner");
        }
        $member = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $params["member"]]);
        if (!isset($member)) {
            throw  new InvalidArgumentException($params["member"] . " this user not exist");
        }
        $notifUser=$this->notificationGenerator->createNotifToUser($member,"","","",["template"=>NotificationGenerator::NOTIFICATION_SEND_REQUEST],NotificationUser::NOTIFICATION_TYPE_ANSWER);
        $home->addRequestNotif($notifUser);
        $em = $this->getDoctrine()->getManager();
        $em->persist($home);
        $em->flush();
        return $home;
    }


}
