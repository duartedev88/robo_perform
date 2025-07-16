@extends('layouts.app')

@section('title', 'Termos de Serviço')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Termos de Serviço</h2>

    <p class="mb-4">
        Ao acessar e utilizar este site/aplicativo, você concorda com os seguintes termos e condições. Se não concordar com qualquer parte destes termos, por favor, não utilize nossos serviços.
    </p>

    <h3 class="text-xl font-semibold mb-2">1. Uso do Serviço</h3>
    <p class="mb-4">
        Este serviço é destinado ao uso pessoal ou comercial legítimo. O usuário compromete-se a não utilizar o sistema de maneira fraudulenta, abusiva ou ilegal.
    </p>

    <h3 class="text-xl font-semibold mb-2">2. Coleta e Uso de Dados</h3>
    <p class="mb-4">
        Coletamos informações conforme descrito na nossa <a href="{{ route('privacidade') }}" class="text-indigo-600 hover:underline">Política de Privacidade</a>. Ao usar o serviço, você concorda com essa coleta e uso.
    </p>

    <h3 class="text-xl font-semibold mb-2">3. Alterações nos Termos</h3>
    <p class="mb-4">
        Reservamo-nos o direito de alterar estes termos a qualquer momento. Quaisquer mudanças serão publicadas nesta página.
    </p>

    <h3 class="text-xl font-semibold mb-2">4. Contato</h3>
    <p>
        Em caso de dúvidas ou solicitações, entre em contato pelo e-mail:
        <a href="mailto:contato@seudominio.com" class="text-indigo-600 hover:underline">contato@seudominio.com</a>
    </p>
@endsection
