<?php

class Message extends BaseController
{
    public function index()
    {
        $this->view('message/index');
    }

    public function message(string $message, string $ref, float $time = 3)
    {
        $data = [
            'message' => $message,
            'ref' => $ref,
            'time' => $time
        ];

        $this->view('message/message', $data);
    }
}
