<?php

namespace App\Handlers\Command;

class SendPushCommand {

    /**
     * @var User
     */
    private $deviceToken;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $data;


    /**
     * SendPushCommand constructor.
     * @param string $deviceToken
     * @param string $title
     * @param string $text
     * @param array $data
     */
    public function __construct(
    $deviceToken, $title, $text,array $data = []
    ) {
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->text = $text;
        $this->data = $data;
        
    }

    /**
     * @return User
     */
    public function getDeviceToken() {
        return $this->deviceToken;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }


    /**
     * @return array
     */
    public function getData() {
        return $this->data;
    }


}
