<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class BadWordsChecker
{
    public function containsBadWords(string $text): bool
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://www.purgomalum.com/service/containsprofanity?text=' . urlencode($text));
        
        return $response->getContent() === 'true';
    }
}