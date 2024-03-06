<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use GuzzleHttp\Client; 


class ChatbotController extends AbstractController
{
    #[Route('/publication/front', name: 'chatbot', methods: ['POST'])]
    public function handleChatbotRequest(Request $request): Response
    {
        // Récupérer le message de l'utilisateur depuis la requête
        $userMessage = $request->getContent();

        // Remplacez 'YOUR_CHATBOT_API_KEY' par votre clé d'API Chatbot
        $apiKey = 'aOs72PVrOL9_Dtgsmvj4ODc_C8MHnmgI';

        // Remplacez l'URL par l'URL correcte de votre API Chatbot
        $apiUrl = 'https://app.chatbot.com/dashboard/65e7b5c4106b510007b3a1ed';

        $client = new Client();

        try {
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'message' => $userMessage,
                ],
            ]);

            // Renvoyer la réponse de l'API Chatbot
            return new Response($response->getBody()->getContents(), 200, [
                'Content-Type' => 'application/json',
            ]);
        } catch (\Exception $e) {
            // Gérer les erreurs de manière appropriée
            return new Response(json_encode(['error' => 'Erreur lors de la communication avec le Chatbot API']), 500, [
                'Content-Type' => 'application/json',
            ]);
        }
    }
}