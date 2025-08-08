<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Gerenciar Seção "Serviços"</h2>
                @if ($isEdit != 0)
                    <div class="mb-8 p-4 border rounded-lg">
                        <h3 class="text-xl font-medium mb-4">{{ $isEdit == 1 ? 'Editar Hero' : 'Adicionar Novo Hero' }}
                        </h3>
                        @if (session()->has('message'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('message') }}
                            </div>
                        @endif


                        <form wire:submit.prevent="save" class="space-y-6 mb-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Título</label>
                                    <input type="text" wire:model="title"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                                    @error('title')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ordem</label>
                                    <input type="number" wire:model="order"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" min="0" />
                                    @error('order')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea wire:model="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Link</label>
                                <input type="text" wire:model="link"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                                @error('link')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col md:flex-row items-center gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Imagem</label>
                                    <input type="file" wire:model="newImage"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('newImage')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $image) }}" class="h-20 w-auto rounded shadow"
                                            alt="Preview" />
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" wire:model="active" />
                                    <span>Ativo</span>
                                </label>
                            </div>
                            <div>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    {{ $isEdit ? 'Atualizar Serviço' : 'Adicionar Serviço' }}
                                </button>
                                @if ($isEdit)
                                    <button type="button" wire:click="resetForm"
                                        class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Cancelar</button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium mb-4">Lista de Serviços</h3>
                    <div class="space-y-4">
                        @if ($isEdit == 0)
                            <button wire:click="addService"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Novo
                            </button>
                        @endif
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100">                               
                                <th class="p-2 text-left">Imagem</th>
                                <th class="p-2 text-left">Título</th>
                                <th class="p-2 text-left">Descrição</th>
                                <th class="p-2 text-left">Link</th>
                                <th class="p-2 text-left">Ordem</th>                                
                                <th class="p-2 text-left">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $service)
                                <tr class="border-t">                                   
                                    <td class="p-2">
                                        @if ($service->image)
                                            <img src="{{ asset('storage/' . $service->image) }}"
                                                class="h-12 w-auto rounded shadow" />
                                        @endif
                                    </td>
                                    <td class="p-2">{{ $service->title }}</td>
                                    <td class="p-2">{{ Str::limit($service->description, 40) }}</td>
                                    <td class="p-2">
                                        @if ($service->link)
                                            <a href="{{ $service->link }}" target="_blank"
                                                class="text-blue-600 underline">Ver</a>
                                        @endif
                                    </td>
                                    <td class="p-2 text-center">{{ $service->order }}</td>                                    
                                    <td class="p-2">
                                        <button wire:click="toggleActive({{ $service->id }})"
                                            class="p-1 rounded-full {{ $service->active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <button wire:click="edit({{ $service->id }})"
                                            class="p-1 rounded-full bg-blue-100 text-blue-600"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg></button>
                                        <button wire:click="delete({{ $service->id }})"
                                            class="p-1 rounded-full bg-red-100 text-red-600"
                                            onclick="return confirm('Deseja remover este serviço?')"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">Nenhum serviço cadastrado
                                        ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
