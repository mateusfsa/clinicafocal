<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicoResource\Pages;
use App\Models\Medico;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedicoResource extends Resource
{
    protected static ?string $model = Medico::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $modelLabel = 'Médico';

    protected static ?string $pluralModelLabel = 'Médicos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('crm')
                    ->label('CRM')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('crm_uf')
                    ->label('UF do CRM')
                    ->options(array_combine(
                        $ufs = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'],
                        $ufs
                    ))
                    ->required(),
                Forms\Components\TextInput::make('especialidade')
                    ->required()
                    ->maxLength(255)
                    ->datalist([
                        'Oftalmologia Geral',
                        'Catarata',
                        'Retina e Vítreo',
                        'Glaucoma',
                        'Córnea',
                        'Oftalmopediatria',
                        'Plástica Ocular',
                        'Estrabismo',
                    ]),
                Forms\Components\TextInput::make('telefone')
                    ->tel()
                    ->maxLength(20)
                    ->mask('(99) 99999-9999'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('Usuário do sistema (login)')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Opcional: vincula o médico a um login para acesso ao painel.'),
                Forms\Components\Toggle::make('ativo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('crm_completo')
                    ->label('CRM'),
                Tables\Columns\TextColumn::make('especialidade')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\IconColumn::make('ativo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('ativo'),
                Tables\Filters\SelectFilter::make('especialidade')
                    ->options(fn () => Medico::query()
                        ->distinct()
                        ->orderBy('especialidade')
                        ->pluck('especialidade', 'especialidade')
                        ->all()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMedicos::route('/'),
            'create' => Pages\CreateMedico::route('/create'),
            'edit' => Pages\EditMedico::route('/{record}/edit'),
        ];
    }
}
