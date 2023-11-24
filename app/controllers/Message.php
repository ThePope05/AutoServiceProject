<?php

class Message extends BaseController
{
    public function index()
    {
        $this->view('message/index');
    }

    public function message(string $message, string $ref, float $time = 3)
    {
        $cleanedMessage = str_replace("_", " ", $message);

        $data = [
            'message' => $cleanedMessage,
            'ref' => $ref,
            'time' => $time
        ];

        $this->view('message/message', $data);
    }
}
