<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Relatorios\ConveniosMaisUtilizados;
use App\Filament\Pages\Relatorios\ProducaoPorMedico;
use App\Filament\Pages\Relatorios\RelatorioStatsOverview;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class RelatorioGerencial extends Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = 'relatorio-gerencial';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Relatórios';

    protected static ?string $title = 'Relatório Gerencial';

    protected static ?string $navigationLabel = 'Relatório Gerencial';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Período')
                    ->schema([
                        DatePicker::make('inicio')
                            ->label('Início')
                            ->default(now()->startOfMonth()),
                        DatePicker::make('fim')
                            ->label('Fim')
                            ->default(now()),
                    ])
                    ->columns(2),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            RelatorioStatsOverview::class,
            ProducaoPorMedico::class,
            ConveniosMaisUtilizados::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }
}
