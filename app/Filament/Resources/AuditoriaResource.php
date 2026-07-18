<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditoriaResource\Pages;
use App\Models\Auditoria;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditoriaResource extends Resource
{
    protected static ?string $model = Auditoria::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?string $modelLabel = 'Registro de Auditoria';

    protected static ?string $pluralModelLabel = 'Auditoria';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('created_at')
                    ->label('Data/hora')
                    ->dateTime('d/m/Y H:i:s'),
                Infolists\Components\TextEntry::make('user.name')
                    ->label('Usuário')
                    ->placeholder('Sistema / visitante'),
                Infolists\Components\TextEntry::make('acao')
                    ->label('Ação')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                Infolists\Components\TextEntry::make('auditavel_type')
                    ->label('Registro')
                    ->formatStateUsing(fn (string $state, Auditoria $record) => class_basename($state) . ' #' . $record->auditavel_id),
                Infolists\Components\TextEntry::make('ip')
                    ->label('IP')
                    ->placeholder('—'),
                Infolists\Components\TextEntry::make('alteracoes')
                    ->label('Alterações')
                    ->getStateUsing(fn (Auditoria $record) => $record->alteracoes
                        ? json_encode($record->alteracoes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                        : '—')
                    ->columnSpanFull()
                    ->extraAttributes(['style' => 'font-family: monospace; white-space: pre-wrap;']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data/hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->placeholder('Sistema / visitante')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('acao')
                    ->label('Ação')
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                    ]),
                Tables\Columns\TextColumn::make('auditavel_type')
                    ->label('Registro')
                    ->formatStateUsing(fn (string $state, Auditoria $record) => class_basename($state) . ' #' . $record->auditavel_id),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('acao')
                    ->options([
                        'created' => 'Criação',
                        'updated' => 'Alteração',
                        'deleted' => 'Exclusão',
                    ]),
                Tables\Filters\SelectFilter::make('auditavel_type')
                    ->label('Tipo de registro')
                    ->options(fn () => Auditoria::query()
                        ->distinct()
                        ->pluck('auditavel_type', 'auditavel_type')
                        ->mapWithKeys(fn ($v, $k) => [$k => class_basename($v)])
                        ->all()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditorias::route('/'),
        ];
    }
}
