<?php

namespace App\Services;
use GuzzleHttp\Client;

class TelegramService
{

    protected $token;
    protected $client;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->client = new Client(['base_uri' => "https://api.telegram.org/bot{$this->token}/"]);
    }

    /**
     * Envio de mensagem
     *
     * @param string $message
     * @return void
     */
    public function sendMessage(string $message)
    {
        $response = $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => env('TELEGRAM_BOT_GROUP_ID'),
                'text' => $message,
                'parse_mode' => 'HTML'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

}

