<section id="agendamento" class="py-20 bg-light">
    <div class="container mx-auto px-5">
        <h2 class="section-title font-montserrat font-bold text-3xl md:text-4xl text-center relative mb-6">
            Agende sua Consulta</h2>
        <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto mb-12">
            Preencha o formulário e nossa equipe entrará em contato para confirmar seu horário.</p>

        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8">
            @if (session('agendamento_success'))
                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800">
                    {{ session('agendamento_success') }}
                </div>
            @endif

            <form wire:submit.prevent="solicitar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <input type="text" wire:model="nome" placeholder="Nome completo"
                            class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                        @error('nome')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <input type="tel" wire:model="telefone" placeholder="Telefone / WhatsApp"
                            class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                        @error('telefone')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <input type="email" wire:model="email" placeholder="E-mail"
                        class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-5">
                    <select wire:model="medico_id"
                        class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                        <option value="">Sem preferência de médico</option>
                        @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->nome }} — {{ $medico->especialidade }}</option>
                        @endforeach
                    </select>
                    @error('medico_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Data preferida</label>
                        <input type="date" wire:model="data_preferida" min="{{ now()->toDateString() }}"
                            class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                        @error('data_preferida')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Período</label>
                        <select wire:model="periodo"
                            class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base focus:border-primary focus:outline-none">
                            <option value="manha">Manhã</option>
                            <option value="tarde">Tarde</option>
                        </select>
                        @error('periodo')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <textarea wire:model="mensagem" placeholder="Observações (opcional)"
                        class="w-full px-4 py-3.5 border border-gray-300 rounded-lg font-sans text-base h-24 focus:border-primary focus:outline-none resize-y"></textarea>
                    @error('mensagem')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-5">
                    <label class="flex items-start gap-3 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" wire:model="consentimento" class="mt-1 rounded border-gray-300">
                        <span>Autorizo o uso dos meus dados pessoais para fins de agendamento e contato,
                            conforme a Lei Geral de Proteção de Dados (LGPD).</span>
                    </label>
                    @error('consentimento')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="mt-6 w-full bg-primary text-white font-montserrat font-bold py-4 rounded-lg hover:opacity-90 transition disabled:opacity-50">
                    <span wire:loading.remove>Solicitar Agendamento</span>
                    <span wire:loading>Enviando...</span>
                </button>
            </form>
        </div>
    </div>
</section>
