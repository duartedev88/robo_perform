@extends('admin.layout')
@section('title', 'Status de Integrações')
@section('content')

    <ul class="space-y-3">
        <li class="p-3 rounded {{ $status['openai'] ? 'bg-green-100' : 'bg-red-100' }}">
            <strong>OpenAI:</strong> {{ $status['openai'] ? 'Conectado' : 'Erro' }}
        </li>
        <li class="p-3 rounded {{ $status['instagram'] ? 'bg-green-100' : 'bg-red-100' }}">
            <strong>Instagram:</strong> {{ $status['instagram'] ? 'Conectado' : 'Erro' }}
        </li>
        <li class="p-3 rounded {{ $status['loja_integrada'] ? 'bg-green-100' : 'bg-red-100' }}">
            <strong>Loja Integrada:</strong> {{ $status['loja_integrada'] ? 'Conectado' : 'Erro' }}
        </li>
    </ul>

@endsection

