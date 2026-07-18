<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-montserrat font-bold text-2xl text-gray-800">Olá, {{ $paciente->nome }}</h1>
            <p class="text-gray-500 text-sm mt-1">Acompanhe suas consultas e documentos.</p>
        </div>
        <button wire:click="logout"
            class="text-sm text-gray-500 hover:text-red-600 border border-gray-300 rounded-lg px-4 py-2 transition">
            Sair
        </button>
    </div>

    {{-- Próximas consultas --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h2 class="font-montserrat font-bold text-lg mb-4 text-gray-800">Próximas consultas</h2>
        @forelse ($proximas as $consulta)
            <div class="flex flex-wrap items-center justify-between gap-2 py-3 border-b last:border-b-0">
                <div>
                    <span class="font-semibold text-gray-800">
                        {{ $consulta->data_hora->format('d/m/Y') }} às {{ $consulta->data_hora->format('H:i') }}
                    </span>
                    <span class="text-gray-500 text-sm block">
                        {{ $consulta->medico?->nome ? 'Dr(a). ' . $consulta->medico->nome . ' — ' . $consulta->medico->especialidade : 'Médico a definir' }}
                    </span>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full
                    {{ $consulta->status === 'agendado' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ ucfirst(str_replace('_', ' ', $consulta->status)) }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Você não possui consultas agendadas.
                <a href="{{ url('/#agendamento') }}" class="text-primary font-semibold hover:underline">Agendar consulta</a>
            </p>
        @endforelse
    </div>

    {{-- Documentos --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h2 class="font-montserrat font-bold text-lg mb-4 text-gray-800">Documentos e receitas</h2>
        @forelse ($documentos as $atendimento)
            <div class="flex flex-wrap items-center justify-between gap-2 py-3 border-b last:border-b-0">
                <div>
                    <span class="font-semibold text-gray-800">
                        Atendimento de {{ $atendimento->data_hora->format('d/m/Y') }}
                    </span>
                    <span class="text-gray-500 text-sm block">
                        {{ $atendimento->medico?->nome ? 'Dr(a). ' . $atendimento->medico->nome : '' }}
                    </span>
                </div>
                <div class="flex gap-2">
                    @if ($atendimento->receita)
                        <a href="{{ route('print.receita', $atendimento->receita) }}" target="_blank"
                            class="text-xs font-semibold bg-primary text-white px-3 py-2 rounded-lg hover:opacity-90 transition">
                            Receita
                        </a>
                    @endif
                    @if ($atendimento->graduacoe)
                        <a href="{{ route('print.graduacao', $atendimento->graduacoe) }}" target="_blank"
                            class="text-xs font-semibold bg-secondary text-white px-3 py-2 rounded-lg hover:opacity-90 transition">
                            Óculos / Graduação
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Nenhum documento disponível ainda.</p>
        @endforelse
    </div>

    {{-- Histórico --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-montserrat font-bold text-lg mb-4 text-gray-800">Histórico de consultas</h2>
        @forelse ($historico as $consulta)
            <div class="flex flex-wrap items-center justify-between gap-2 py-3 border-b last:border-b-0">
                <div>
                    <span class="text-gray-800">{{ $consulta->data_hora->format('d/m/Y H:i') }}</span>
                    <span class="text-gray-500 text-sm block">
                        {{ $consulta->medico?->nome ? 'Dr(a). ' . $consulta->medico->nome : '' }}
                    </span>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full
                    {{ $consulta->status === 'finalizado' ? 'bg-green-100 text-green-800' : ($consulta->status === 'cancelado' ? 'bg-gray-200 text-gray-600' : 'bg-blue-100 text-blue-800') }}">
                    {{ ucfirst(str_replace('_', ' ', $consulta->status)) }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Nenhuma consulta anterior.</p>
        @endforelse
    </div>
</div>
