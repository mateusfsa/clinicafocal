<?php

namespace App\Filament\Resources\ReceitaResource\Pages;

use App\Filament\Resources\ReceitaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceitas extends ListRecords
{
    protected static string $resource = ReceitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
