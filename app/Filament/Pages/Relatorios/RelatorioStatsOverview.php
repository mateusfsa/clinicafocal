<?php

namespace App\Filament\Pages\Relatorios;

use App\Models\Agendamento;
use App\Models\Conta;
use App\Models\Paciente;
use App\Models\Pagamento;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class RelatorioStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        [$inicio, $fim] = $this->periodo();

        $realizadas = Agendamento::query()
            ->where('status', Agendamento::STATUS_FINALIZADO)
            ->whereBetween('data_hora', [$inicio, $fim])
            ->count();

        $canceladas = Agendamento::query()
            ->where('status', Agendamento::STATUS_CANCELADO)
            ->whereBetween('data_hora', [$inicio, $fim])
            ->count();

        $pacientesNovos = Paciente::query()
            ->whereBetween('created_at', [$inicio, $fim])
            ->count();

        $faturamento = Pagamento::query()
            ->whereHas('agendamento', fn ($q) => $q->whereBetween('data_hora', [$inicio, $fim]))
            ->sum('valor');

        $inadimplencia = Conta::query()
            ->where('tipo', Conta::TIPO_RECEBER)
            ->vencidas()
            ->sum('valor');

        return [
            Stat::make('Consultas realizadas', $realizadas),
            Stat::make('Consultas canceladas', $canceladas),
            Stat::make('Pacientes novos', $pacientesNovos),
            Stat::make('Faturamento', 'R$ ' . number_format((float) $faturamento, 2, ',', '.')),
            Stat::make('Inadimplência (recebíveis vencidos)', 'R$ ' . number_format((float) $inadimplencia, 2, ',', '.'))
                ->color('danger'),
        ];
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function periodo(): array
    {
        $inicio = $this->filters['inicio'] ?? null;
        $fim = $this->filters['fim'] ?? null;

        return [
            ($inicio ? Carbon::parse($inicio) : now()->startOfMonth())->startOfDay(),
            ($fim ? Carbon::parse($fim) : now())->endOfDay(),
        ];
    }
}
