<div>
    <!-- Input de Upload -->
    <div class="mb-4">
        <input 
            type="file" 
            wire:model="image" 
            accept="image/*"
            class="block w-full text-sm text-gray-500
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-md file:border-0
                   file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700
                   hover:file:bg-blue-100"
        >
        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    <!-- Botão de Upload -->
    <button 
        wire:click="save" 
        wire:loading.attr="disabled"
        wire:target="save"
        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
    >
        <span wire:loading.remove wire:target="save">Enviar Imagem</span>
        <span wire:loading wire:target="save">Enviando...</span>
    </button>

    <!-- Preview e Imagem Carregada -->
    <div class="mt-6">
        @if($image)
            <h3 class="font-medium mb-2">Preview:</h3>
            <img 
                src="{{ $image->temporaryUrl() }}" 
                class="max-w-full h-auto border rounded shadow-sm max-h-60"
            >
        @endif

        @if($uploadedImageUrl)
            <div class="mt-4">
                <h3 class="font-medium mb-2">Imagem Carregada:</h3>
                <img 
                    src="{{ $uploadedImageUrl }}" 
                    class="max-w-full h-auto border rounded shadow-md max-h-80"
                >
                <button 
                    wire:click="removeImage" 
                    class="mt-2 px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600"
                >
                    Remover Imagem
                </button>
            </div>
        @endif
    </div>
</div>