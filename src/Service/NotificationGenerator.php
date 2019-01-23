<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Notification;
use App\Entity\NotificationUser;
use App\Entity\Device;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use RedjanYm\FCMBundle\FCMClient;
use sngrl\PhpFirebaseCloudMessaging\Client;

class NotificationGenerator
{

    const NOTIFICATION_WELCOME = "default.welcome";

    private $em;
    private $translator;
    private $params;

    /**
     * @param EntityManagerInterface the Doctrine entity Manager
     */
    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator, ParameterBagInterface $params)
    {
        $this->em = $entityManager;
        $this->translator = $translator;
        $this->params = $params;
    }

    private function getWelcomeNotification()
    {
        //check if exist
        $notif = $this->em->getRepository(Notification::class)->findOneByName(self::NOTIFICATION_WELCOME);
        if (!$notif)
        {
            //create 
            $notif = new Notification;
            $notif->setName(self::NOTIFICATION_WELCOME);
            $notif->setTitle("notification.welcome.title");
            $notif->setDescription("notification.welcome.description");

            $this->em->persist($notif);
            $this->em->flush();
        }


        return $notif;
    }

    public function getWelcomeName()
    {
        return self::NOTIFICATION_WELCOME;
    }

    private function getTemplateNotificataion($name)
    {
        return $this->em->getRepository(Notification::class)->findOneByName($name);
    }

    public function createNotifToUser($user, $name, $title, $description, $options = [])
    {
        //find user 
        //check if exist
        if (!($user instanceof User))
        {
            $user = $this->em->getRepository(User::class)->find($user);
        }
        if ($options && isset($options["template"]) && $options["template"])
        {
            switch ($options["template"])
            {
                case self::NOTIFICATION_WELCOME:
                    $notif = $this->getWelcomeNotification();
                    break;
                default:
                    $notif = $this->getTemplateNotificataion($options["template"]);
                    break;
            }
        } else
        {
            //create  notification
            $notif = new Notification;
            $notif->setName($name);
            $notif->setTitle($title);
            $notif->setDescription($description);
            if ($options && isset($options["params"]) && $options["params"])
            {
                $notif->setParams($options["params"]);
            }
            $this->em->persist($notif);
            $this->em->flush();
        }
        //create relation
        $notifUser = new NotificationUser;
        $notifUser->setNotification($notif);
        $notifUser->setUser($user);

        $this->em->persist($notifUser);
        $this->em->flush();
        $devices = $this->em->getRepository(Device::class)->findByUser($user);
        $langs[] = [];
        $result = [];
        if ($devices)
        {
            foreach ($devices as $device)
            {
                if (!isset($langs[$device->getLang() ? $device->getLang() : $this->params->get("framework.default_locale")]))
                {
                    $langs[$device->getLang() ? $device->getLang() : $this->params->get("framework.default_locale")] = [];
                }
                $langs[$device->getLang() ? $device->getLang() : $this->params->get("framework.default_locale")][] = $device->getToken();
            }

            foreach ($langs as $lang => $tokens)
            {
                if ($tokens && count($tokens))
                {
                    $result[] = $this->sendPush($notif->getTitle(), $notif->getDescription(), $tokens, $lang, $notif->getParams());
                }
            }
        }
        return $result;
    }

    /**
     * sends push
     * @param int $id NotificationUser->getId()
     */
    public function sendPush($title, $descrition, $token, $lang = null, $parameters = [])
    {
        if (!$parameters)
        {
            $parameters = [];
        }
        $fcmClient = new FCMClient((new Client())->setApiKey(getEnv("FIREBASE_API_KEY")));
        $notification = $fcmClient->createDeviceNotification($this->translator->trans($title, $parameters, null, $lang), $this->translator->trans($descrition, $parameters, null, $lang), $token);
        $notification->addData("vibrate", [1000, 500, 2000]);
        return $fcmClient->sendNotification($notification);
    }

}
