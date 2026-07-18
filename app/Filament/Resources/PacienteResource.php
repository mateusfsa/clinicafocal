<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PacienteResource\Pages;
use App\Filament\Resources\PacienteResource\RelationManagers;
use App\Models\Paciente;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cpf')
                    ->required()
                    ->maxLength(14)
                    ->mask('999.999.999-99')
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('telefone')
                    ->tel()
                    ->required()
                    ->maxLength(15)
                    ->mask('(99) 99999-9999'),
                Forms\Components\DatePicker::make('data_nascimento')
                    ->required(),
                Forms\Components\Select::make('convenio_id')
                    ->label('Convênio')
                    ->relationship('convenio', 'nome', fn ($query) => $query->where('ativo', true))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Particular')
                    ->live(),
                Forms\Components\TextInput::make('numero_carteirinha')
                    ->label('Nº da carteirinha')
                    ->maxLength(30)
                    ->visible(fn (Forms\Get $get) => filled($get('convenio_id'))),
                Forms\Components\DatePicker::make('validade_carteirinha')
                    ->label('Validade da carteirinha')
                    ->visible(fn (Forms\Get $get) => filled($get('convenio_id'))),
                Forms\Components\Toggle::make('consentimento_lgpd')
                    ->label('Consentimento LGPD')
                    ->helperText('Paciente autorizou o tratamento dos seus dados pessoais (a data/hora do aceite é registrada automaticamente).'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('criar_acesso')
                    ->label('Criar acesso ao portal')
                    ->icon('heroicon-o-key')
                    ->visible(fn (Paciente $record) => $record->user_id === null)
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->label('Senha inicial')
                            ->default(fn () => Str::password(10))
                            ->required()
                            ->minLength(8)
                            ->helperText('Informe esta senha ao paciente. Ele poderá trocá-la em "Esqueci minha senha".'),
                    ])
                    ->action(function (Paciente $record, array $data) {
                        if (User::where('email', $record->email)->exists()) {
                            Notification::make()
                                ->title('Já existe um usuário com o e-mail ' . $record->email . '.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $user = User::create([
                            'name' => $record->nome,
                            'email' => $record->email,
                            'password' => $data['password'],
                            'tipo' => User::TIPO_PACIENTE,
                        ]);

                        $record->update(['user_id' => $user->id]);

                        Notification::make()
                            ->title('Acesso ao portal criado.')
                            ->body('Login: ' . $record->email . ' — informe a senha escolhida ao paciente.')
                            ->success()
                            ->persistent()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPacientes::route('/'),
            'create' => Pages\CreatePaciente::route('/create'),
            'edit' => Pages\EditPaciente::route('/{record}/edit'),
        ];
    }
}
