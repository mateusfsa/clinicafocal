<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Gerenciar Seção "Equipe"</h2>

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-medium mb-4">Lista de Membros</h3>
                    <div class="space-y-4">
                        <button wire:click="showCreateModal"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Novo
                        </button>
                    </div>
                </div>

                <table class="w-full table-auto border border-gray-200 rounded">
                    <thead>
                        <tr>
                            <th class="p-2 text-left">Imagem</th>
                            <th class="p-2 text-left">Nome</th>
                            <th class="p-2 text-left">Especialidade</th>
                            <th class="p-2 text-left">CRM</th>
                            <th class="p-2 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr class="border-t">
                                <td class="p-2 ">
                                    @if ($member->image)
                                        <img src="{{ asset('storage/' . $member->image) }}"
                                            class="w-12 h-12 object-cover rounded-full">
                                    @endif
                                </td>
                                <td class="p-2 ">{{ $member->name }}</td>
                                <td class="p-2 ">{{ $member->role }}</td>
                                <td class="p-2 ">{{ $member->crm }}</td>
                                <td class="p-2 ">
                                    <button wire:click="showEditModal({{ $member->id }})"
                                        class="p-1 rounded-full bg-blue-100 text-blue-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg></button>
                                    <button wire:click="confirmDelete({{ $member->id }})"
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
                        @endforeach
                    </tbody>
                </table>

                <!-- Modal Form -->
                @if ($modalFormVisible)
                    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
                        <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                            <h3 class="text-lg font-semibold mb-4">{{ $member_id ? 'Editar' : 'Novo' }} Membro</h3>
                            <form wire:submit.prevent="save" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="block">Nome</label>
                                    <input type="text" wire:model="name" class="w-full border rounded px-3 py-1" />
                                    @error('name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="block">Especialidade</label>
                                    <input type="text" wire:model="role" class="w-full border rounded px-3 py-1" />
                                    @error('role')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="block">CRM</label>
                                    <input type="text" wire:model="crm" class="w-full border rounded px-3 py-1" />
                                </div>
                                <div class="mb-3">
                                    <label class="block">LinkedIn</label>
                                    <input type="text" wire:model="linkedin"
                                        class="w-full border rounded px-3 py-1" />
                                </div>
                                <div class="mb-3">
                                    <label class="block">Instagram</label>
                                    <input type="text" wire:model="instagram"
                                        class="w-full border rounded px-3 py-1" />
                                </div>
                                <div class="mb-3">
                                    <label class="block">E-mail</label>
                                    <input type="email" wire:model="email" class="w-full border rounded px-3 py-1" />
                                </div>
                                <div class="mb-3">
                                    <label class="block">Foto</label>
                                    <input type="file" wire:model="image" class="w-full" />
                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}"
                                            class="w-16 h-16 object-cover rounded-full mt-2">
                                    @endif
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" wire:click="$set('modalFormVisible', false)"
                                        class="px-4 py-2 rounded bg-gray-200">Cancelar</button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded bg-blue-600 text-white">{{ $member_id ? 'Salvar' : 'Adicionar' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Modal Delete -->
                @if ($modalConfirmDeleteVisible)
                    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
                        <div class="bg-white p-6 rounded-lg w-full max-w-md">
                            <p class="mb-4">Tem certeza que deseja excluir este membro?</p>
                            <div class="flex justify-end gap-2">
                                <button type="button" wire:click="$set('modalConfirmDeleteVisible', false)"
                                    class="px-4 py-2 rounded bg-gray-200">Cancelar</button>
                                <button type="button" wire:click="delete"
                                    class="px-4 py-2 rounded bg-red-600 text-white">Excluir</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
