<?php

namespace App\Handlers\CommandHandlers;

use paragraph1\phpFCM\Notification;
use App\Handlers\Command\SendPushCommand;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;
use Doctrine\ORM\EntityManagerInterface;
use paragraph1\phpFCM\Client;

class SendPushHandler {


    /**
     *
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    private $client;

    /**
     * SendPushHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Client $client, EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->client = $client;
    }

    public function handle(SendPushCommand $command) {
       
        
        $title = $command->getTitle();
        $text = $command->getText();
        $deviceToken = $command->getDeviceToken();
        $data=$command->getData();
        
        $message = new Message();

        $message->addRecipient(new Device($deviceToken));
        $message->setNotification(new Notification($title, $text));

        $response =  $this->client->send($message);

        $notification = (new \App\Entity\Notification())
                ->setDescription($text)
                ->setTitle($title)
                ->setReadByUser(false)
                ->setDate(new \DateTime());
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

}
