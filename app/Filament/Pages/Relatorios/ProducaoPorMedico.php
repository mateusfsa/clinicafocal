<?php

namespace App\Filament\Pages\Relatorios;

use App\Models\Agendamento;
use App\Models\Medico;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Carbon;

class ProducaoPorMedico extends TableWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Produção por médico';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        [$inicio, $fim] = $this->periodo();

        return $table
            ->query(
                Medico::query()
                    ->withCount([
                        'agendamentos as consultas_realizadas' => fn ($q) => $q
                            ->where('status', Agendamento::STATUS_FINALIZADO)
                            ->whereBetween('data_hora', [$inicio, $fim]),
                        'agendamentos as consultas_canceladas' => fn ($q) => $q
                            ->where('status', Agendamento::STATUS_CANCELADO)
                            ->whereBetween('data_hora', [$inicio, $fim]),
                    ])
                    ->withSum([
                        'pagamentos as faturamento' => fn ($q) => $q
                            ->whereBetween('agendamentos.data_hora', [$inicio, $fim]),
                    ], 'valor')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Médico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('especialidade'),
                Tables\Columns\TextColumn::make('consultas_realizadas')
                    ->label('Realizadas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('consultas_canceladas')
                    ->label('Canceladas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('faturamento')
                    ->label('Faturamento')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format((float) ($state ?? 0), 2, ',', '.'))
                    ->default(0),
            ])
            ->defaultSort('consultas_realizadas', 'desc')
            ->paginated(false);
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
