<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InstagramService
{
    public function uploadImageAndPublish(string $imageUrl, string $caption)
    {
//        $accessToken = env('FB_ACCESS_TOKEN');
//        $igUserId = env('IG_USER_ID');
//
//        // Passo 1: Criar o recurso de mídia no Instagram
//        $mediaResponse = Http::post("https://graph.facebook.com/v19.0/{$igUserId}/media", [
//            'image_url' => $imageUrl,
//            'caption' => $caption,
//            'access_token' => $accessToken,
//        ]);
//
//        if (!$mediaResponse->successful()) {
//            return null;
//        }
//
//        $creationId = $mediaResponse->json()['id'] ?? null;
//
//        // Passo 2: Publicar a mídia
//        if ($creationId) {
//            $publishResponse = Http::post("https://graph.facebook.com/v19.0/{$igUserId}/media_publish", [
//                'creation_id' => $creationId,
//                'access_token' => $accessToken,
//            ]);
//
//            return $publishResponse->json();
//        }
//
//        return null;

        // Simula resposta de sucesso
        return ['id' => 'mocked_media_id'];

    }
}
