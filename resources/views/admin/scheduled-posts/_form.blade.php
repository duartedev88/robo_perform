@csrf

@if(isset($scheduledPost) && $scheduledPost->product_id)
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">ID do Produto (Loja Integrada)</label>
        <input type="text"
               value="{{ $scheduledPost->product_id }}"
               class="w-full border p-2 rounded bg-gray-100 text-gray-600 text-sm"
               readonly>
    </div>
@endif

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Nome do Produto *</label>
    <input type="text"
           name="product_name"
           value="{{ old('product_name', $scheduledPost->product_name ?? '') }}"
           class="w-full border p-2 rounded text-sm"
           required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Descrição</label>
    <textarea name="description"
              rows="3"
              class="w-full border p-2 rounded text-sm">{{ old('description', $scheduledPost->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">URL da Imagem *</label>
    <input type="url"
           name="image_url"
           value="{{ old('image_url', $scheduledPost->image_url ?? '') }}"
           class="w-full border p-2 rounded text-sm"
           required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Preço do Produto (R$)</label>
    <input type="number"
           step="0.01"
           name="price"
           value="{{ old('price', $scheduledPost->price ?? '') }}"
           class="w-full border p-2 rounded text-sm">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Legenda (gerada pela IA)</label>
    <textarea name="caption"
              rows="4"
              class="w-full border p-2 rounded text-sm">{{ old('caption', $scheduledPost->caption ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Agendar Publicação *</label>
    <input type="datetime-local"
           name="scheduled_at"
           value="{{ old('scheduled_at', isset($scheduledPost) && $scheduledPost->scheduled_at ? \Carbon\Carbon::parse($scheduledPost->scheduled_at)->format('Y-m-d\TH:i') : '') }}"
           class="w-full border p-2 rounded text-sm"
           required>
</div>

@if(isset($scheduledPost))
    <div class="mb-4">
        <label class="inline-flex items-center text-sm text-gray-700">
            <input type="checkbox"
                   name="posted"
                   value="1"
                {{ $scheduledPost->posted ? 'checked' : '' }}>
            <span class="ml-2">Marcar como já postado</span>
        </label>
    </div>
@endif

<div class="flex items-center gap-4 mt-6">
    <button class="bg-[#2e2d87] hover:bg-[#1f1e63] text-white px-6 py-2 rounded text-sm font-medium">
        Salvar
    </button>
  <button class="bg-[#2e2d87] hover:bg-[#1f1e63] text-white px-6 py-2 rounded text-sm font-medium">
      <a href="{{ route('admin.scheduled-posts.index') }}"
         >
          Cancelar
      </a>
  </button>

</div>
