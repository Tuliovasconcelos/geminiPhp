# GeminiAPI

GeminiAPI é uma biblioteca PHP para integração com a API de geração de linguagem da Gemini. Esta biblioteca permite que você envie solicitações para a API Gemini e receba respostas automatizadas para diversas perguntas e contextos.

## Instalação

Você pode instalar esta biblioteca via Composer. Execute o seguinte comando no terminal:

composer require tuliovasconcelos/geminiphp


## Como Usar

```php
<?php

require 'vendor/autoload.php';

use GeminiAPI\GeminiAPI;

// Instanciar a biblioteca
$apiKey = "Sua-API-Key";
$systemInstruction = "Responda de forma clara e concisa com conceitos do PHP.";
$question = "Como criar uma I.A?";

try {
    $geminiAPI = new GeminiAPI($apiKey, $systemInstruction);
    $geminiAPI->setRequestData($question, 0.7, 50, 0.9, 2048);
    $response = $geminiAPI->sendRequest();

    echo $response;
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
