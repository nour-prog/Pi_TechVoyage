<?php
// src/Service/PerspectiveAPIService.php
namespace App\Service;

use GuzzleHttp\Client;

class PerspectiveAPIService
{
private $apiKey;
private $apiUrl;

public function __construct($apiKey, $apiUrl)
{
$this->apiKey = $apiKey;
$this->apiUrl = $apiUrl;
}

public function analyzeContent($content)
{
$client = new Client();

$response = $client->request('POST', $this->apiUrl, [
'headers' => [
'Content-Type' => 'application/json',
],
'json' => [
'comment' => [
'text' => $content,
],
'requestedAttributes' => [
'TOXICITY' => ['scoreType' => 'PROBABILITY'],
],
],
'query' => [
'key' => $this->apiKey,
],
]);

return json_decode($response->getBody(), true);
}
}
?>