<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Gerenciar Seção "Hero"</h2>
                <!-- Formulário de Hero -->
                @if ($editMode != 0)
                    <div class="mb-8 p-4 border rounded-lg">
                        <h3 class="text-xl font-medium mb-4">{{ $editMode == 1 ? 'Editar Hero' : 'Adicionar Novo Hero' }}
                        </h3>
                        @if (session()->has('message'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form wire:submit.prevent="saveHero">                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Title*</label>
                                    <input type="text" wire:model="title"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('title')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subtitle*</label>
                                    <textarea wire:model="subtitle" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                    @error('subtitle')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Botão 01 texto</label>
                                    <input type="text" wire:model="button1_text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('button1_text')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Botão 01 link</label>
                                    <input type="text" wire:model="button1_link"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('button1_link')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Botão 02 texto</label>
                                    <input type="text" wire:model="button2_text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('button2_text')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Botão 02 link</label>
                                    <input type="text" wire:model="button2_link"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('button2_link')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Imagem de fundo</label>
                                    <input type="file" wire:model="newBackgroundImage"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('newBackgroundImage')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    @if ($background_image && !$newBackgroundImage)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $background_image) }}"
                                                alt="Imagem de fundo atual" class="h-20">
                                        </div>
                                        <!-- Progress Bar -->
                                        <div x-show="uploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end space-x-2">
                                @if ($editMode)
                                    <button type="button" wire:click="resetForm"
                                        class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">
                                        Cancelar
                                    </button>
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    {{ $editMode == 1 ? 'Atualizar' : 'Salvar' }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Lista de Heros -->
                <div class="p-4 border rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-medium mb-4">Heros</h3>
                        <div class="space-y-4">
                            @if ($editMode == 0)
                                <button wire:click="addHero"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Novo
                                </button>
                            @endif
                        </div>
                    </div>
                    @if ($heroes->isEmpty())
                        <p class="text-gray-500">Nenhum Hero cadastrado ainda.</p>
                    @else
                        <div class="flex justify-between mb-4">
                            <div class="space-y-4" wire:sortable="updateOrder">
                                @foreach ($heroes as $hero)
                                    <div wire:sortable.item="{{ $hero->id }}" wire:key="hero-{{ $hero->id }}"
                                        class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                                        <div class="flex items-center space-x-4">
                                            <div wire:sortable.handle class="cursor-move">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            @if ($hero->background_image)
                                                <img src="{{ asset('storage/' . $hero->background_image) }}"
                                                    alt="{{ $hero->title }}"
                                                    class="h-12 w-12 rounded-full object-cover">
                                            @else
                                                <div
                                                    class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-medium">{{ $hero->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $hero->subtitle }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="toggleActive({{ $hero->id }})"
                                                class="p-1 rounded-full {{ $hero->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button wire:click="editHero({{ $hero->id }})"
                                                class="p-1 rounded-full bg-blue-100 text-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </button>
                                            <button wire:click="deleteHero({{ $hero->id }})"
                                                onclick="return confirm('Tem certeza que deseja excluir este Hero?')"
                                                class="p-1 rounded-full bg-red-100 text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        [wire\:sortable] {
            cursor: move;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpush
