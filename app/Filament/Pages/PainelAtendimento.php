<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AtendimentoStatsOverview;
use App\Filament\Widgets\ListaChamada;
use Filament\Pages\Page;

class PainelAtendimento extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string $view = 'filament.pages.painel-atendimento';

    protected function getHeaderWidgets(): array
    {
        return [
            AtendimentoStatsOverview::class,
            ListaChamada::class,
        ];
    }
}
