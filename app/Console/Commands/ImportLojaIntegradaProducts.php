<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\ScheduledPost;
use App\Services\OpenAIService;
use OpenAI\Exceptions\ErrorException;

class ImportLojaIntegradaProducts extends Command
{
    protected $signature = 'loja-integrada:import-products';
    protected $description = 'Importa até 3 produtos em destaque da Loja Integrada por dia para agendamento de posts';

    public function handle(OpenAIService $openAI)
    {
        $apiKey = env('LOJA_INTEGRADA_API_KEY');
        $appKey = env('LOJA_INTEGRADA_APP_KEY');

        if (!$apiKey || !$appKey) {
            $this->error('As variáveis LOJA_INTEGRADA_API_KEY e LOJA_INTEGRADA_APP_KEY não estão configuradas.');
            return 1;
        }

        if (Cache::has('import-products-today')) {
            $this->info('⏳ A importação já foi executada hoje. Tente novamente amanhã.');
            return 0;
        }

        $imported = 0;
        $offset = 0;
        $limit = 10;

        while ($imported < 3) {
            $response = Http::withHeaders([
                'Authorization' => "chave_api {$apiKey} aplicacao {$appKey}"
            ])->get('https://api.awsli.com.br/v1/produto', [
                'destaque' => 'true',
                'limit' => $limit,
                'offset' => $offset,
            ]);

            if (!$response->successful()) {
                $this->error('Erro ao buscar produtos na Loja Integrada:');
                $this->line('Status: ' . $response->status());
                $this->line('Corpo: ' . $response->body());
                break;
            }

            $products = $response->json()['objects'] ?? [];

            if (empty($products)) {
                $this->info('✅ Nenhum produto novo encontrado.');
                break;
            }

            foreach ($products as $product) {
                $productId = $product['id'];

                // Ignorar se já existir no banco
                if (ScheduledPost::where('product_id', $productId)->exists()) {
                    continue;
                }

                $productName = $product['nome'];
                $productDesc = $product['descricao_curta'] ?? null;

                if (empty($productDesc)) {
                    $productDesc = "Conheça o produto: {$productName}. Ideal para quem busca qualidade e performance.";
                }

                // Buscar imagem
                $imageUrl = null;
                $imageResponse = Http::withHeaders([
                    'Authorization' => "chave_api {$apiKey} aplicacao {$appKey}"
                ])->get('https://api.awsli.com.br/v1/produto_imagem/', [
                    'produto' => $productId
                ]);

                if ($imageResponse->successful()) {
                    $images = $imageResponse->json()['objects'] ?? [];
                    if (count($images)) {
                        $imagePath = $images[0]['caminho'] ?? null;
                        $imageUrl = $imagePath ? 'https://cdn.awsli.com.br/' . ltrim($imagePath, '/') : null;
                    }
                }

                if (!$imageUrl) {
                    $this->warn("Produto {$productName} não possui imagem. Ignorado.");
                    continue;
                }

                // Buscar preço
                $priceResponse = Http::withHeaders([
                    'Authorization' => "chave_api {$apiKey} aplicacao {$appKey}"
                ])->get("https://api.awsli.com.br/v1/produto_preco/{$productId}");

                $productPrice = null;
                if ($priceResponse->successful()) {
                    $json = $priceResponse->json();
                    $productPrice = isset($json['cheio']) ? (float) $json['cheio'] : null;
                }

                if (is_null($productPrice)) {
                    $this->warn("Produto {$productName} não possui preço válido. Ignorado.");
                    continue;
                }

                // Gerar legenda com GPT
                $caption = '';
                try {
                    $caption = $openAI->generateCaption($productName, $productDesc, $productPrice);
                    sleep(5); // evita rate limit
                } catch (ErrorException $e) {
                    $this->error("Erro ao gerar legenda para '{$productName}': {$e->getMessage()}");
                    continue;
                }

                // Definir horários de agendamento
                $scheduleAt = match ($imported) {
                    0 => now()->setTime(10, 0),
                    1 => now()->setTime(12, 0),
                    2 => now()->setTime(14, 0),
                    default => now()->addHours($imported * 2),
                };

                // Salvar no banco
                ScheduledPost::create([
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'description' => $productDesc,
                    'image_url' => $imageUrl,
                    'caption' => $caption,
                    'price' => $productPrice,
                    'scheduled_at' => $scheduleAt,
                    'posted' => false,
                ]);

                $this->info("✔ Produto '{$productName}' importado com sucesso.");
                $imported++;

                if ($imported >= 3) {
                    break 2; // sai do foreach e do while
                }
            }

            $offset += $limit;
        }

        Cache::put('import-products-today', true, now()->addHours(24));
        $this->info('✅ Importação diária concluída com sucesso.');
        return 0;
    }
}
