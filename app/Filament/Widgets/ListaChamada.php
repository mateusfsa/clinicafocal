<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use Filament\Widgets\Widget;

class ListaChamada extends Widget
{
    protected static string $view = 'filament.widgets.lista-chamada';

    protected function getViewData(): array
    {
        return [
            'pacientes' => Agendamento::with('paciente')
                ->whereDate('data_hora', today())
                ->whereIn('status', ['compareceu', 'em_atendimento'])
                ->orderBy('data_hora')
                ->get(),
        ];
    }
}
