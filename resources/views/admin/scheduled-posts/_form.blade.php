<!-- _form.blade.php -->
@csrf

@if(isset($scheduledPost) && $scheduledPost->product_id)
    <div class="mb-4">
        <label class="block">ID do Produto (Loja Integrada)</label>
        <input type="text" value="{{ $scheduledPost->product_id }}" class="w-full border p-2 rounded bg-gray-100 text-gray-600" readonly>
    </div>
@endif

<div class="mb-4">
    <label class="block">Nome do Produto</label>
    <input type="text" name="product_name" value="{{ old('product_name', $scheduledPost->product_name ?? '') }}" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
    <label class="block">Descrição</label>
    <textarea name="description" class="w-full border p-2 rounded">{{ old('description', $scheduledPost->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block">URL da Imagem</label>
    <input type="url" name="image_url" value="{{ old('image_url', $scheduledPost->image_url ?? '') }}" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
    <label class="block">Preço do Produto</label>
    <input type="number" step="0.01" name="price" value="{{ old('price', $scheduledPost->price ?? '') }}" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
    <label class="block">Legenda (gerada pela IA)</label>
    <textarea name="caption" class="w-full border p-2 rounded">{{ old('caption', $scheduledPost->caption ?? '') }}</textarea>
</div>

@if(isset($scheduledPost))
    <div class="mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="posted" value="1" {{ $scheduledPost->posted ? 'checked' : '' }}>
            <span class="ml-2">Já postado</span>
        </label>
    </div>
@endif

<button class="bg-[#2e2d87] text-white px-4 py-2 rounded">Salvar</button>
