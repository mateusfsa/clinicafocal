<?php

namespace App\Filament\Resources\ConvenioResource\Pages;

use App\Filament\Resources\ConvenioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConvenio extends EditRecord
{
    protected static string $resource = ConvenioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
