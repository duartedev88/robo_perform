<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledPost;
use App\Services\OpenAIService;

class GenerateFakePosts extends Command
{
    protected $signature = 'posts:generate-fake';
    protected $description = 'Gera posts falsos para teste com legendas geradas pela OpenAI';

    protected OpenAIService $openAI;

    public function __construct(OpenAIService $openAI)
    {
        parent::__construct();
        $this->openAI = $openAI;
    }

    public function handle()
    {
        $fakePosts = [
            [
                'product_name' => 'Drink Tropical',
                'description' => 'Um drink refrescante para o verão.',
                'image_url' => 'https://media.istockphoto.com/id/1310122326/pt/foto/close-up-shot-of-young-woman-working-late-with-laptop-in-the-dark.jpg?s=612x612&w=0&k=20&c=WI0mi5HPQGa4Ob7vxK7pFQRh0YjrjCtTBahsrizjhao=',
                'posted' => false,
            ],
            [
                'product_name' => 'Cocktail Clássico',
                'description' => 'O clássico que nunca sai de moda.',
                'image_url' => 'https://westgroup.com.br/site/wp-content/uploads/2023/10/shutterstock_110678570.webp',
                'posted' => false,
            ],
        ];

        foreach ($fakePosts as $post) {
            $caption = $this->openAI->generateCaption($post['product_name'], $post['description']);

            ScheduledPost::updateOrCreate(
                ['product_name' => $post['product_name']],
                [
                    'description' => $post['description'],
                    'image_url' => $post['image_url'],
                    'caption' => $caption,
                    'posted' => false,
                ]
            );
        }

        $this->info('Posts falsos gerados com sucesso com legendas geradas pela OpenAI!');
    }
}
