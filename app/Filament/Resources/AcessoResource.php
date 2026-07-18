<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcessoResource\Pages;
use App\Models\Acesso;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AcessoResource extends Resource
{
    protected static ?string $model = Acesso::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?string $modelLabel = 'Acesso';

    protected static ?string $pluralModelLabel = 'Log de Acessos';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
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
                    ->placeholder('—')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail informado')
                    ->placeholder('—')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('evento')
                    ->colors([
                        'success' => 'login',
                        'gray' => 'logout',
                        'danger' => 'falha',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'falha' => 'Tentativa falha',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('ip')
                    ->label('IP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('Navegador')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('evento')
                    ->options([
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'falha' => 'Tentativa falha',
                    ]),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name'),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcessos::route('/'),
        ];
    }
}
