<?php

namespace App\Handlers\CommandHandlers;


use App\Handlers\Command\SendMailCommand;
use Psr\Log\LoggerInterface;
use SimpleBus\Message\Recorder\RecordsMessages;
use Symfony\Component\Translation\Translator;

class SendMailHandler
{
/**
* @var \Swift_Mailer
*/
private $mailer;

/**
* @var Translator
*/
private $translator;

/**
* @var LoggerInterface
*/
private $logger;

/**
* @var string
*/
private $companyName;

/**
* @var string
*/
private $companyEmail;
/**
* @var RecordsMessages
*/
private $eventRecorder;

/**
* SendEmailHandler constructor.
* @param \Swift_Mailer $mailer
* @param Translator $translator
* @param LoggerInterface $logger
* @param $companyName
* @param $companyEmail
* @param RecordsMessages $eventRecorder
*/
public function __construct(\Swift_Mailer $mailer) {
    
$this->mailer = $mailer;
$this->companyName = getenv('MAILER_NAME');
$this->companyEmail = getenv('MAILER_USER');
}

public function handle(SendMailCommand $command)
{
    $message = (new \Swift_Message($command->getSubject()))
        ->setFrom($this->companyEmail, $this->companyName)
        ->setBody($command->getBody(), 'text/html');

    $addresses = $command->getTo();
    if (!is_array($addresses)) {
        $addresses = [$addresses];
    }

    $count = 0;

    foreach ($addresses as $address) {
    $message
        ->setTo($address, $command->getToName());
    $count += $this->mailer->send($message);
    }

}
}