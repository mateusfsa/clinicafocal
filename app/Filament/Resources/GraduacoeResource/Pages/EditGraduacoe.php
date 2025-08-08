<?php

namespace App\Filament\Resources\GraduacoeResource\Pages;

use App\Filament\Resources\GraduacoeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGraduacoe extends EditRecord
{
    protected static string $resource = GraduacoeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
