<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $label =  'Configuração';
    protected static ?string $navigationLabel = 'Configuração';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';    

    protected static string $view = 'filament.pages.settings';
}
