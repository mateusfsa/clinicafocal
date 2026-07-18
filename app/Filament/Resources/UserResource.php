<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?string $modelLabel = 'Usuário';

    protected static ?string $pluralModelLabel = 'Usuários';

    /**
     * Somente administradores gerenciam usuários.
     */
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('tipo')
                    ->label('Perfil de acesso')
                    ->options([
                        User::TIPO_ADMIN => 'Administrador',
                        User::TIPO_MEDICO => 'Médico',
                        User::TIPO_ATENDENTE => 'Atendente',
                    ])
                    ->required()
                    ->helperText('Define o que o usuário pode ver no painel. Usuário sem perfil não acessa o sistema.'),
                Forms\Components\TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation) => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(8)
                    ->maxLength(255)
                    ->helperText(fn (string $operation) => $operation === 'edit'
                        ? 'Deixe em branco para manter a senha atual.'
                        : 'Mínimo de 8 caracteres.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('tipo')
                    ->label('Perfil')
                    ->colors([
                        'danger' => User::TIPO_ADMIN,
                        'primary' => User::TIPO_MEDICO,
                        'success' => User::TIPO_ATENDENTE,
                    ])
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        User::TIPO_ADMIN => 'Administrador',
                        User::TIPO_MEDICO => 'Médico',
                        User::TIPO_ATENDENTE => 'Atendente',
                        default => 'Sem acesso',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Perfil')
                    ->options([
                        User::TIPO_ADMIN => 'Administrador',
                        User::TIPO_MEDICO => 'Médico',
                        User::TIPO_ATENDENTE => 'Atendente',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    // Impede o usuário de excluir a própria conta
                    ->visible(fn (User $record) => $record->id !== auth()->id()),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
