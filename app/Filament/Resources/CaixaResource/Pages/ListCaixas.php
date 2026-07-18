<?php

namespace App\Filament\Resources\CaixaResource\Pages;

use App\Filament\Resources\CaixaResource;
use App\Models\Caixa;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCaixas extends ListRecords
{
    protected static string $resource = CaixaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('abrir')
                ->label('Abrir Caixa')
                ->icon('heroicon-o-lock-open')
                ->visible(fn () => Caixa::atual() === null)
                ->form([
                    Forms\Components\TextInput::make('valor_abertura')
                        ->label('Valor inicial em caixa (R$)')
                        ->numeric()
                        ->minValue(0)
                        ->step('0.01')
                        ->default(0)
                        ->required(),
                ])
                ->action(function (array $data) {
                    Caixa::create([
                        'user_abertura_id' => auth()->id(),
                        'valor_abertura' => $data['valor_abertura'],
                        'aberto_em' => now(),
                        'status' => Caixa::STATUS_ABERTO,
                    ]);

                    Notification::make()
                        ->title('Caixa aberto. Os pagamentos registrados a partir de agora serão vinculados a ele.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
