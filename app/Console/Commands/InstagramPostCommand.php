<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledPost;
use App\Services\InstagramService;

class InstagramPostCommand extends Command
{
    protected $signature = 'instagram:post';
    protected $description = 'Publica automaticamente um post agendado no Instagram';

    public function handle(InstagramService $instagram)
    {
        $post = ScheduledPost::where('posted', false)
            ->whereDate('created_at', '<=', now())
            ->orderBy('created_at')
            ->first();

        if (!$post) {
            $this->info('Nenhum post disponível.');
            return;
        }

        $todayPost = ScheduledPost::whereDate('updated_at', now()->toDateString())
            ->where('posted', true)
            ->exists();

        if ($todayPost) {
            $this->info('Já foi feito um post hoje. Aguardando o próximo dia.');
            return;
        }

        $result = $instagram->uploadImageAndPublish($post->image_url, $post->caption);

        if ($result && isset($result['id'])) {
            $post->posted = true;
            $post->save();
            $this->info('Post publicado com sucesso!');
        } else {
            $this->error('Erro ao publicar no Instagram.');
        }
    }
}
