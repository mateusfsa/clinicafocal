<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Gerenciar "Itens de Menu"</h2>

                @if (session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="bg-white rounded shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Adicionar Novo Item</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Label</label>
                            <input type="text" wire:model="newItem.label"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL</label>
                            <input type="text" wire:model="newItem.url"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ordem</label>
                            <input type="number" wire:model="newItem.order"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="flex items-end">
                            <button wire:click="addItem"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Itens do Menu</h2>

                    <form wire:submit.prevent="updateItems">
                        <div class="space-y-4">
                            @foreach ($items as $index => $item)
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center border-b py-1">
                                    <div>
                                        @if ($index === 0)
                                            <label class="block text-sm font-medium text-gray-700">Ordem</label>
                                        @endif
                                        <input type="number" wire:model="items.{{ $index }}.order"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm w-1">
                                    </div>
                                    <div>
                                        @if ($index === 0)
                                            <label class="block text-sm font-medium text-gray-700">Label</label>
                                        @endif
                                        <input type="text" wire:model="items.{{ $index }}.label"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-md">
                                    </div>
                                    <div>
                                        @if ($index === 0)
                                            <label class="block text-sm font-medium text-gray-700">URL</label>
                                        @endif
                                        <input type="text" wire:model="items.{{ $index }}.url"
                                            class="block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        @if ($index === 0)
                                            <label class="block text-sm font-medium text-gray-700">Ativo?</label>
                                        @endif
                                        <button wire:click="toggleActive({{ $item['id'] }})"
                                            class="p-1 rounded-full {{ $item['is_active'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div>
                                        @if ($index === 0)
                                            <label class="block text-sm font-medium text-gray-700">Excluir</label>
                                        @endif
                                        <button wire:click="deleteItem({{ $item['id'] }})"
                                            class="p-1 rounded-full bg-red-100 text-red-600"
                                            onclick="return confirm('Deseja remover este serviço?')"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
