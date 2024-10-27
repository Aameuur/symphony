<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

class TwilioTestController extends AbstractController
{
    private Client $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function sendMessage(): Response
    {
        $message = $this->twilio->messages->create(
            '+21622043442', // To this number
            [
                'from' => '+15094123723', // From your Twilio number
                'body' => 'Hello from Symfony!'
            ]
        );

        return new Response('Message sent: ' . $message->sid);
    }
}
