<?php

namespace GeminiPhp;

class GeminiPhp
{
    private $apiKey;
    private $systemInstruction;
    private $url;
    private $requestData;

    public function __construct($apiKey, $systemInstruction)
    {
        $this->apiKey = $apiKey;
        $this->systemInstruction = $systemInstruction;
        $this->url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=" . $apiKey;
    }

    public function setRequestData($question)
    {
        $this->requestData = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" =>  $this->systemInstruction . $question
                        ]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 1,
                "topK" => 0,
                "topP" => 0.95,
                "maxOutputTokens" => 8192,
                "stopSequences" => []
            ],
            "safetySettings" => [
                [
                    "category" => "HARM_CATEGORY_HARASSMENT",
                    "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                ],
                [
                    "category" => "HARM_CATEGORY_HATE_SPEECH",
                    "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                ],
                [
                    "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                    "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                ],
                [
                    "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
                    "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
                ]
            ]
        ];
    }

    public function sendRequest()
    {
        $postData = json_encode($this->requestData);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = curl_exec($curl);

        if (curl_error($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception("Erro na solicitação CURL: " . $error);
        }

        curl_close($curl);

        $response_data = json_decode($response, true);

        if (isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
            $response_text = $response_data['candidates'][0]['content']['parts'][0]['text'];
            $response_text = str_replace("*", "", $response_text);
            $response_text = str_replace("#", "", $response_text);
            return $response_text;
        } else {
            throw new \Exception("Resposta inesperada da API: " . $response);
        }
    }
}
