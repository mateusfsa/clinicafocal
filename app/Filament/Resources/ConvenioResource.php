<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConvenioResource\Pages;
use App\Models\Convenio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConvenioResource extends Resource
{
    protected static ?string $model = Convenio::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $modelLabel = 'Convênio';

    protected static ?string $pluralModelLabel = 'Convênios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('registro_ans')
                    ->label('Registro ANS')
                    ->maxLength(20),
                Forms\Components\TextInput::make('telefone')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('valor_consulta')
                    ->label('Valor de repasse da consulta (R$)')
                    ->numeric()
                    ->minValue(0)
                    ->step('0.01'),
                Forms\Components\Toggle::make('ativo')
                    ->default(true),
                Forms\Components\Textarea::make('observacoes')
                    ->label('Observações')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('registro_ans')
                    ->label('Registro ANS')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('valor_consulta')
                    ->label('Repasse consulta')
                    ->formatStateUsing(fn ($state) => $state !== null ? 'R$ ' . number_format((float) $state, 2, ',', '.') : '—'),
                Tables\Columns\TextColumn::make('pacientes_count')
                    ->label('Pacientes')
                    ->counts('pacientes'),
                Tables\Columns\IconColumn::make('ativo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('ativo'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConvenios::route('/'),
            'create' => Pages\CreateConvenio::route('/create'),
            'edit' => Pages\EditConvenio::route('/{record}/edit'),
        ];
    }
}
