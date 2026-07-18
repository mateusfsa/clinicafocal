<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use App\Models\Pagamento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AtendimentoStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $recebidoHoje = Pagamento::whereDate('created_at', today())->sum('valor');

        return [
            Stat::make('Agendamentos hoje', Agendamento::hoje()->where('status', '!=', Agendamento::STATUS_CANCELADO)->count())
                ->icon('heroicon-o-calendar'),
            Stat::make('Aguardando atendimento', Agendamento::hoje()->porStatus(Agendamento::STATUS_COMPARECEU)->count())
                ->icon('heroicon-o-clock')
                ->color('warning'),
            Stat::make('Em atendimento', Agendamento::hoje()->porStatus(Agendamento::STATUS_EM_ATENDIMENTO)->count())
                ->icon('heroicon-o-user')
                ->color('info'),
            Stat::make('Recebido hoje', 'R$ ' . number_format((float) $recebidoHoje, 2, ',', '.'))
                ->icon('heroicon-o-banknotes')
                ->color('success'),
        ];
    }
}
