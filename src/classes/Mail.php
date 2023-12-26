<?php

namespace App\classes;

use Symfony\Component\Dotenv\Dotenv;
use Mailjet\Client;
use \Mailjet\Resources;
use RuntimeException;

class Mail
{
    private $api_key;
    private $api_key_secret;

    public function __construct()
    {
        $this->loadApiKeys();
    }

    private function loadApiKeys()
    {
        // Charger les variables d'environnement depuis le fichier .env
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env.local');
        // Assigner les clés API à partir des variables d'environnement
        $this->api_key = $_ENV['MAILJET_API_KEY'] ?? null;
        $this->api_key_secret = $_ENV['MAILJET_API_KEY_SECRET'] ?? null;
    }

    public function send($to_email, $to_name, $subject, $content)
    {
        if (!$this->api_key || !$this->api_key_secret) {
            // Gestion de l'absence des clés API
            throw new \RuntimeException('Les clés API Mailjet ne sont pas définies.');
        }

        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "ventalis.entreprise@gmail.com",
                        'Name' => "Ventalis"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5430431,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];

        try {
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            if ($response->success()) {


                // echo '<div class="container alert alert-success">L\'e-mail a été envoyé avec succès</div>';

                return true;
            } else {
                // Gestion de l'échec de l'envoi de l'e-mail
                throw new RuntimeException('Échec de l\'envoi de l\'e-mail.');
            }
        } catch (\Exception $e) {
            // Gestion des exceptions, log, etc.
            throw new \RuntimeException('Erreur lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }
    }
}
