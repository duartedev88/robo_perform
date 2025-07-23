<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    public function uploadImageAndPublish(string $imageUrl, string $caption)
    {
        $accessToken = env('FB_ACCESS_TOKEN');
        $igUserId = env('IG_USER_ID');

        // Passo 1: Criar mídia
        $mediaResponse = Http::asForm()->post("https://graph.facebook.com/v19.0/{$igUserId}/media", [
            'image_url' => $imageUrl,
            'caption' => $caption,
            'access_token' => $accessToken,
        ]);


        if (!$mediaResponse->successful()) {
            Log::error('Erro ao criar mídia no Instagram', [
                'status' => $mediaResponse->status(),
                'body' => $mediaResponse->body(),
            ]);
            return null;
        }

        $creationId = $mediaResponse->json()['id'] ?? null;

        if (!$creationId) {
            Log::error('ID de criação não retornado pela API do Instagram', [
                'response' => $mediaResponse->json(),
            ]);
            return null;
        }

        // Passo 2: Publicar mídia
        $publishResponse = Http::asForm()->post("https://graph.facebook.com/v19.0/{$igUserId}/media_publish", [
            'creation_id' => $creationId,
            'access_token' => $accessToken,
        ]);


        if (!$publishResponse->successful()) {
            Log::error('Erro ao publicar no Instagram', [
                'status' => $publishResponse->status(),
                'body' => $publishResponse->body(),
            ]);
            return null;
        }

        $result = $publishResponse->json();

        if (!isset($result['id'])) {
            Log::error('Publicação aparentemente não criada. Resposta:', [
                'response' => $result,
            ]);
            return null;
        }

        Log::info('✅ Post publicado com sucesso no Instagram', [
            'post_id' => $result['id'],
        ]);

        return $result;
    }
}
