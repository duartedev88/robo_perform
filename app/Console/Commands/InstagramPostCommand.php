<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledPost;
use App\Services\InstagramService;
use Illuminate\Log;

class InstagramPostCommand extends Command
{
    protected $signature = 'instagram:post {--dry-run : Simula o post sem publicar}';

    protected $description = 'Publica automaticamente um post agendado no Instagram';

    public function handle(InstagramService $instagram)
    {
        $post = ScheduledPost::where('posted', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->first();

        if (!$post) {
            $this->info('Nenhum post disponível.');
            \Log::debug('[instagram:post] Nenhum post agendado para agora.');
            return;
        }

        $todayPost = ScheduledPost::whereDate('posted_at', now()->toDateString())->exists();


        if ($todayPost) {
            $this->info('Já foi feito um post hoje. Aguardando o próximo dia.');
            return;
        }

        // ⚠️ Simulação
        if ($this->option('dry-run')) {
            $this->info("🚫 Simulação ativada (--dry-run)");
            $this->info("📦 Produto: {$post->product_name}");
            $this->info("🖼 Imagem: {$post->image_url}");
            $this->info("💬 Legenda: {$post->caption}");
            return;
        }

        $result = $instagram->uploadImageAndPublish($post->image_url, $post->caption);

        if ($result && isset($result['id'])) {
            $post->posted = true;
            $post->posted_at = now();
            $post->save();
            $this->info('Post publicado com sucesso!');
        } else {
            $this->error('Erro ao publicar no Instagram.');
        }
    }
}
