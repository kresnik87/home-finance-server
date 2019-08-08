<?php

namespace App\Handlers\Command;

class SendMailCommand
{
/**
* @var string|array
*/
private $to;

/**
* @var string
*/
private $toName;

/**
* @var string
*/
private $replyTo;

/**
* @var string
*/
private $replyToName;

/**
* @var string
*/
private $subject;

/**
* @var string
*/
private $text;

/**
* @var string
*/
private $body;

/**
* @var array
*/
private $images;

/**
* SendEmailCommand constructor.
* @param $to
* @param $toName
* @param $subject
* @param $text
* @param $body
* @param $images
* @param null $replyTo
* @param null $replyToName
*/
public function __construct($to,$toName,$subject,$text,$body,$images,$replyTo = null,$replyToName = null) {
    $this->to = $to;
    $this->toName = $toName;
    if (!$replyTo) {
        $this->replyTo = $to;
    } else {
        $this->replyTo = $replyTo;
    }
    if (!$replyToName) {
        $this->replyToName = $toName;
    } else {
        $this->replyToName = $replyToName;
    }
    $this->subject = $subject;
    $this->text = $text;
    $this->body = $body;
    $this->images = $images;
}

/**
* @return array|string
*/
    public function getTo()
    {
        return $this->to;
    }

/**
* @return string
*/
    public function getToName()
    {
        return $this->toName;
    }

/**
* @return string
*/
    public function getReplyTo()
    {
        return $this->replyTo;
    }

/**
* @return string
*/
    public function getReplyToName()
    {
        return $this->replyToName;
    }

/**
* @return string
*/
    public function getSubject()
    {
        return $this->subject;
    }

/**
* @return string
*/
    public function getText()
    {
        return $this->text;
    }

/**
* @return string
*/
    public function getBody()
    {
        return $this->body;
    }

/**
* @return array
*/
    public function getImages()
    {
        return $this->images;
    }
}