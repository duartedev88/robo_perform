@extends('admin.layout')

@section('title', 'Postagens Agendadas')

@section('content')
    <a href="{{ route('admin.scheduled-posts.create') }}" class="bg-[#2e2d87] text-white px-4 py-2 rounded">Novo Post</a>
    <form method="GET" class="mb-4 pt-10 flex flex-wrap gap-2 items-center">
        <input type="text" name="product_name" placeholder="Buscar produto por nome..."
               value="{{ request('product_name') }}"
               class="border rounded px-3 py-2 w-64">

        <select name="status" class="border rounded px-3 py-2">
            <option value="">Todos</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
            <option value="posted" {{ request('status') === 'posted' ? 'selected' : '' }}>Postado</option>
        </select>

        <button type="submit" class="bg-[#2e2d87] text-white px-4 py-2 rounded">Filtrar</button>

        @if(request()->has('product_name') || request()->has('status'))
            <a href="{{ route('admin.scheduled-posts.index') }}" class="ml-2 text-sm text-red-600">Limpar filtros</a>
        @endif
    </form>

    <table class="w-full mt-4 bg-white rounded shadow text-sm">
        <thead>
        <tr>
            <th class="p-2 text-left">Produto</th>
            <th class="p-2">Imagem</th>
            <th class="p-2">Preço</th>
            <th class="p-2">ID Loja</th>
            <th class="p-2">Status</th>
            <th class="p-2" colspan="2">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr class="border-t">
                <td class="p-2">{{ $post->product_name }}</td>
                <td class="p-2">
                    <img src="{{ $post->image_url }}" class="h-12 max-w-[70px] object-contain" />
                </td>
                <td class="p-2">
                    @if($post->price)
                        R$ {{ number_format($post->price, 2, ',', '.') }}
                    @else
                        <span class="text-gray-500 italic">Sem preço</span>
                    @endif
                </td>
                <td class="p-2 text-center text-gray-700">
                    {{ $post->product_id ?? '-' }}
                </td>
                <td class="p-2">
                    @if($post->posted)
                        <span class="text-green-600 font-semibold">Postado</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Pendente</span>
                    @endif
                </td>
                <td class="p-2 space-x-2">
                    <a href="{{ route('admin.scheduled-posts.edit', $post) }}" class="text-blue-500">Editar</a>
                    <form method="POST" action="{{ route('admin.scheduled-posts.destroy', $post) }}" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Excluir?')">Excluir</button>
                    </form>
                </td>
                <td class="p-2">
                    <form method="POST" action="{{ route('admin.scheduled-posts.post-now', $post) }}" class="inline">
                        @csrf
                        <button class="text-green-600" onclick="return confirm('Postar agora?')">Postar Agora</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection
