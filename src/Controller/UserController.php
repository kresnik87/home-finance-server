<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Device;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Vich\UploaderBundle\Storage\StorageInterface;
use App\Service\NotificationGenerator;
use App\Helpers\ObjectUtils;

class UserController extends Controller
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

    public function meAction(Request $request)
    {
        $params = json_decode($request->getContent(), true);

        $user = $this->getUser();
        if ($params && count($params))
        {
            $user = $this->objUtils->initialize($user, $params);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $user;
    }

    public function registerAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);
        if (!$params || !count($params) || !isset($params["username"]) || !isset($params["email"]) || !isset($params["password"]))
        {
            throw new InvalidArgumentException("Needs params to register");
        }
        //check email and username
        $email = $this->getDoctrine()->getRepository(User::class)->findOneByEmail($params["email"]);
        if ($email)
        {
            throw new InvalidArgumentException("Email in use");
        }
        //check passwords match
        if ($params["password"] !== $params["password_confirm"])
        {
            throw new InvalidArgumentException("Passwords not match");
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->objUtils->initialize(new User(), $params, ["password"]);
        $user->setPlainPassword($params["password"]);
        $em->persist($user);
        $em->flush();
        return $user;
    }

    public function logoutAction(Request $request)
    {
        $token = $this->get("security.token_storage")->getToken();
        //unregister device
        $device = $this->getDoctrine()->getRepository(Device::class)->findOneByToken($token);
        if ($device)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($device);
            $em->flush();
        }
        try {
            $request->getSession()->invalidate();
            $this->get("security.token_storage")->setToken(null);
            return new Response();
        } catch (\Exception $e) {
            return new Response($e, 400);
        }
    }

    public function uploadImageAction(Request $request, $id = null)
    {
        $uploadedFile = $request->files->get('file');
        //get user
        $user = $id ? $this->getDoctrine()->getRepository(User::class)->find($id) : $this->getUser();
        $user->setImageFile($uploadedFile);
        //save data
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response(getEnv("BASE_URL") . $this->storage->resolveUri($user, "imageFile"));
    }

}
