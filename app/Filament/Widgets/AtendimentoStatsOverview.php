<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use App\Models\Pagamento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AtendimentoStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Agendamentos Hoje', Agendamento::whereDate('data_hora', today())->count()),
            Stat::make('Pacientes em Atendimento', Agendamento::where('status', 'em_atendimento')->count()),
            Stat::make('Pacientes Aguardando', Agendamento::where('status', 'compareceu')->count()),
            Stat::make('Total Recebido Hoje', Pagamento::whereDate('created_at', today())->sum('valor')),
        ];
    }
}
