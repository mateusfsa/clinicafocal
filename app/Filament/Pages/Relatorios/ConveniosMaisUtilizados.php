<?php

namespace App\Filament\Pages\Relatorios;

use App\Models\Convenio;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Carbon;

class ConveniosMaisUtilizados extends TableWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Convênios mais utilizados';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        [$inicio, $fim] = $this->periodo();

        return $table
            ->query(
                Convenio::query()
                    ->withCount([
                        'agendamentos as total_atendimentos' => fn ($q) => $q
                            ->whereBetween('data_hora', [$inicio, $fim]),
                    ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Convênio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_atendimentos')
                    ->label('Atendimentos no período')
                    ->sortable(),
            ])
            ->defaultSort('total_atendimentos', 'desc')
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
