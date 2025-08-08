<div class="container mx-auto py-4 px-4 sm:px-6 lg:px-8">

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4">
        Novo Paciente
    </button>

    @if($isOpen)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
            <div class="min-h-screen bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
                <form class="w-full">
                    <div class="border-b px-6 py-4 flex justify-between items-center">
                        <h5 class="text-lg font-semibold">
                            {{ $paciente_id ? 'Editar Paciente' : 'Novo Paciente' }}
                        </h5>
                        <button type="button" class="text-gray-500 hover:text-gray-700" wire:click="closeModal">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="nome">
                            @error('nome') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="email">
                            @error('email') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Telefone</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="telefone">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Data de Nascimento</label>
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="data_nascimento">
                            @error('data_nascimento') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">CPF</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="cpf" maxlength="11">
                            @error('cpf') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Observações</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="observacoes"></textarea>
                        </div>
                    </div>
                    <div class="border-t px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" wire:click="closeModal">
                            Cancelar
                        </button>
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click.prevent="store()">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">Nome</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">E-mail</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">Telefone</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">Data Nasc.</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">CPF</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">Observações</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-semibold uppercase text-sm">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pacientes as $p)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-gray-700">{{ $p->nome }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $p->email }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $p->telefone }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ \Carbon\Carbon::parse($p->data_nascimento)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $p->cpf }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $p->observacoes }}</td>
                    <td class="py-3 px-4">
                        <div class="flex space-x-2">
                            <button wire:click="edit({{ $p->id }})" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 rounded">
                                Editar
                            </button>
                            <button wire:click="delete({{ $p->id }})" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded" onclick="return confirm('Remover este paciente?')">
                                Remover
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>