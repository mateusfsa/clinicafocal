<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaixaResource\Pages;
use App\Models\Caixa;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CaixaResource extends Resource
{
    protected static ?string $model = Caixa::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?string $modelLabel = 'Caixa';

    protected static ?string $pluralModelLabel = 'Caixa';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('aberto_em', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('aberto_em')
                    ->label('Abertura')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('userAbertura.name')
                    ->label('Aberto por'),
                Tables\Columns\TextColumn::make('valor_abertura')
                    ->label('Valor inicial')
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format((float) $state, 2, ',', '.')),
                Tables\Columns\TextColumn::make('pagamentos_sum_valor')
                    ->label('Recebimentos')
                    ->sum('pagamentos', 'valor')
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format((float) ($state ?? 0), 2, ',', '.')),
                Tables\Columns\TextColumn::make('valor_fechamento')
                    ->label('Valor no fechamento')
                    ->formatStateUsing(fn ($state) => $state !== null
                        ? 'R$ ' . number_format((float) $state, 2, ',', '.')
                        : '—'),
                Tables\Columns\TextColumn::make('fechado_em')
                    ->label('Fechamento')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'aberto',
                        'gray' => 'fechado',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('fechar')
                    ->label('Fechar Caixa')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->visible(fn (Caixa $record) => $record->status === Caixa::STATUS_ABERTO)
                    ->form(fn (Caixa $record) => [
                        Forms\Components\Placeholder::make('resumo')
                            ->label('Valor esperado (abertura + recebimentos)')
                            ->content('R$ ' . number_format($record->valor_esperado, 2, ',', '.')),
                        Forms\Components\TextInput::make('valor_fechamento')
                            ->label('Valor contado no fechamento (R$)')
                            ->numeric()
                            ->minValue(0)
                            ->step('0.01')
                            ->required(),
                        Forms\Components\Textarea::make('observacoes')
                            ->label('Observações (diferenças, sangrias etc.)')
                            ->rows(2),
                    ])
                    ->action(function (Caixa $record, array $data) {
                        $record->update([
                            'valor_fechamento' => $data['valor_fechamento'],
                            'observacoes' => $data['observacoes'] ?? $record->observacoes,
                            'fechado_em' => now(),
                            'user_fechamento_id' => auth()->id(),
                            'status' => Caixa::STATUS_FECHADO,
                        ]);

                        $diferenca = (float) $data['valor_fechamento'] - $record->valor_esperado;

                        Notification::make()
                            ->title('Caixa fechado.')
                            ->body($diferenca == 0.0
                                ? 'Sem diferença de caixa.'
                                : 'Diferença de R$ ' . number_format($diferenca, 2, ',', '.'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaixas::route('/'),
        ];
    }
}
