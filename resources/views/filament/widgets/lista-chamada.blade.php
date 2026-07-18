<x-filament-widgets::widget>
    <x-filament::section heading="Lista de chamada — hoje">
        <div wire:poll.15s>
            @forelse ($agendamentos as $agendamento)
                <div class="flex flex-wrap items-center justify-between gap-3 py-3 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                    <div class="flex items-center gap-4">
                        <span class="font-mono font-semibold text-lg">
                            {{ $agendamento->data_hora->format('H:i') }}
                        </span>
                        <div>
                            <p class="font-semibold">{{ $agendamento->paciente->nome }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $agendamento->medico?->nome ? 'Dr(a). ' . $agendamento->medico->nome : 'Sem médico definido' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-filament::badge :color="match ($agendamento->status) {
                            'agendado' => 'warning',
                            'compareceu' => 'success',
                            'em_atendimento' => 'info',
                            default => 'gray',
                        }">
                            {{ ucfirst(str_replace('_', ' ', $agendamento->status)) }}
                        </x-filament::badge>

                        @if ($agendamento->status === 'agendado')
                            <x-filament::button size="sm" color="success" wire:click="checkin({{ $agendamento->id }})">
                                Check-in
                            </x-filament::button>
                        @elseif ($agendamento->status === 'compareceu')
                            <x-filament::button size="sm" color="info" wire:click="iniciar({{ $agendamento->id }})">
                                Iniciar
                            </x-filament::button>
                        @elseif ($agendamento->status === 'em_atendimento')
                            <x-filament::button size="sm" color="gray" wire:click="finalizar({{ $agendamento->id }})">
                                Finalizar
                            </x-filament::button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Nenhum paciente na fila hoje.</p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
