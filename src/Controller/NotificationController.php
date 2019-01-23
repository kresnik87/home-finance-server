<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Device;
use App\Entity\NotificationUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Helpers\ObjectUtils;
use App\Service\NotificationGenerator;

class NotificationController extends AbstractController
{

    /**
     * @var NotificationGenerator
     */
    protected $notGen;
    
    /**
     * @var ObjectUtils 
     */
    private $objUtils;

    public function __construct(NotificationGenerator $notif, ObjectUtils $objUtils)
    {
        $this->notGen = $notif;
        $this->objUtils = $objUtils;
    }

    public function setDevice(Request $request, $id = null)
    {
        $params = json_decode($request->getContent(), true);

        $user = $this->getUser();
        if (is_null($id) && isset($params["uuid"]))
        {
            $id = $params["uuid"];
        }
        if ($id)
        {
            $device = $this->getDoctrine()->getRepository(Device::class)->find($id);
            if (!$device)
            {
                $device = $this->objUtils->initialize(new Device(), $params, ["user"]);
            }
//            if ($device->getUser() && $device->getUser()->getId() != $user->getId())
//            {
//                throw new AccessDeniedException("Device $id is owned by user " . $device->getUser()->getId());
//            }
        } else
        {
            throw new NotFoundHttpException("Device not found");
        }
        //update variables 
        $device = $this->objUtils->initialize($device, $params, ["user"]);

        $device->setUser($user);

        $em = $this->getDoctrine()->getManager();

        $em->persist($device);
        $em->flush();
        $this->notGen->createNotifToUser($user, null, null, null, ["template" => $this->notGen->getWelcomeName()]);
        return $device;
    }

    public function notificationsAction(Request $request)
    {
        $user = $this->getUser();
        $limit = null;
        $offset = null;
        $order = ["createdDate" => "DESC"];
        $pagination = $request->get("pagination");
        if ($pagination)
        {
            $page = $request->get("page") ? $request->get("page") : 1;
            $itemsPerPage = $request->get("itemsPerPage") ? $request->get("itemsPerPage") : $this->getParameter("api_platform.collection.pagination.items_per_page");
            $limit = $page * $itemsPerPage;
            $offset = ($page - 1) * $itemsPerPage;
        }

        $order = $request->get("order") ? $request->get("order") : $order;

        return $this->getDoctrine()->getRepository(NotificationUser::class)->findBy(["user" => $user, "deleted" => false], $order, $limit, $offset);
    }

    public function CountNotifAction()
    {
        $user = $this->getUser();
        return new Response(count($this->getDoctrine()->getRepository(NotificationUser::class)->findBy(["user" => $user, "readed" => false, "deleted" => false])));
    }

}
