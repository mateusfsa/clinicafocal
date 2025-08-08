<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Gerenciar Seção "Sobre"</h2>
                @if (session()->has('message'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" id="title" wire:model="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="description_1" class="block text-sm font-medium text-gray-700">Descrição 1</label>
                        <textarea id="description_1" wire:model="description_1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('description_1')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="description_2" class="block text-sm font-medium text-gray-700">Descrição 2</label>
                        <textarea id="description_2" wire:model="description_2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Imagem</label>
                        @if ($image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Preview" class="mb-4 w-64">
                        @endif
                        <input type="file" id="image" wire:model="newImage"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('newImage')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>


                    <h3 class="font-bold">Características</h3>
                    @foreach ($features as $index => $feature)
                        <div class="flex gap-4 border p-1 rounded">
                            <input type="text" wire:model="features.{{ $index }}.icon"
                                placeholder="Ícone (ex: fas fa-eye)"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">                            
                            <input type="text" wire:model="features.{{ $index }}.title" placeholder="Título"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <input type="text" wire:model="features.{{ $index }}.description"
                                placeholder="Descrição" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <button type="button" wire:click="removeFeature({{ $index }})"
                                class="p-1 rounded-full bg-red-100 text-red-600"><svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg></button>
                        </div>
                    @endforeach
                    <button type="button" wire:click="addFeature"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Novo</button>


                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
