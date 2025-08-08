<?php

namespace App\Filament\Resources\GraduacoeResource\Pages;

use App\Filament\Resources\GraduacoeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGraduacoes extends ListRecords
{
    protected static string $resource = GraduacoeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
