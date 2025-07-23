<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    /**
     * Gera uma legenda criativa para o Instagram com nome, descrição e preço do produto.
     *
     * @param string $productName
     * @param string $description
     * @param float|string|null $price
     * @return string
     */
    public function generateCaption(string $productName, string $description = '', $price = null): string
    {
        // Formata o preço se for fornecido
        $priceFormatted = null;

        if (!is_null($price)) {
            // Garante conversão segura de string para float
            $numericPrice = is_string($price)
                ? floatval(str_replace(['.', ','], ['', '.'], $price))
                : floatval($price);

            $priceFormatted = 'Preço: R$ ' . number_format($numericPrice, 2, ',', '.');
        }

        // Monta prompt para IA
        $userPrompt = "Crie uma legenda envolvente para Instagram sobre o produto \"$productName\". com no máximo 250 caracteres"
            . ($description ? "Descrição: $description. " : '')
            . ($priceFormatted ? "$priceFormatted. " : '')
            . "Use linguagem criativa, amigável e incentive o cliente a comprar.";

        $messages = [
            [
                'role' => 'system',
                'content' => 'Você é um redator criativo que cria legendas envolventes para posts de Instagram sobre produtos. Utilize poucos emogis'
            ],
            [
                'role' => 'user',
                'content' => $userPrompt
            ],
        ];

        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'max_tokens' => 100,
            'temperature' => 0.8,
        ]);

        $caption = trim($response->choices[0]->message->content ?? '');

        return $caption ?: "Confira nosso produto \"$productName\"!" . ($priceFormatted ? " $priceFormatted" : '');
    }
}
