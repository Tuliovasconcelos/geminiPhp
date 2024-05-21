# GeminiPhp

GeminiPhp é uma biblioteca PHP para integração com I.A do google. Esta biblioteca permite que você envie solicitações para a API Gemini e receba respostas automatizadas para diversas perguntas e contextos.

## Instalação

Você pode instalar esta biblioteca via Composer. Execute o seguinte comando no terminal:

composer require tuliovasconcelos/geminiphp


## Como Usar

```php
<?php

require 'vendor/autoload.php';

use GeminiPhp\GeminiPhp;

// Instanciar a biblioteca
$PhpKey = "Sua-API-Key";
$systemInstruction = "Responda de forma clara e concisa com conceitos do PHP.";
$question = "Como criar uma I.A?";

try {
    $geminiPhp = new GeminiPhp($PhpKey, $systemInstruction);
    $geminiPhp->setRequestData($question, 0.7, 50, 0.9, 2048);
    $response = $geminiPhp->sendRequest();

    echo $response;
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
