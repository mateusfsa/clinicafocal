<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AtendimentoStatsOverview;
use App\Filament\Widgets\ListaChamada;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Painel de Atendimento';

    protected static ?string $navigationLabel = 'Início';

    public function getWidgets(): array
    {
        return [
            AtendimentoStatsOverview::class,
            ListaChamada::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }
}
