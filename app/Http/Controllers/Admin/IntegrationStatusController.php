<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class IntegrationStatusController extends Controller
{
    public function index()
    {
        $status = [
            'openai' => $this->checkOpenAI(),
            'instagram' => $this->checkInstagram(),
            'loja_integrada' => $this->checkLojaIntegrada(),
        ];

        return view('admin.integration-status.index', compact('status'));
    }

    protected function checkOpenAI()
    {
        try {
            $res = Http::withToken(env('OPENAI_API_KEY'))->get('https://api.openai.com/v1/models');
            return $res->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function checkInstagram()
    {
        try {
            $res = Http::get("https://graph.facebook.com/v19.0/me?access_token=" . env('FB_ACCESS_TOKEN'));
            return $res->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function checkLojaIntegrada()
    {
        try {
            $res = Http::withHeaders([
                'Authorization' => 'chave_api ' . env('LOJA_INTEGRADA_EMAIL') . ':' . env('LOJA_INTEGRADA_TOKEN'),
            ])->get('https://api.awsli.com.br/v1/produto');

            return $res->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}

