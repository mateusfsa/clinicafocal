<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PagamentoResource\Pages;
use App\Filament\Resources\PagamentoResource\RelationManagers;
use App\Models\Agendamento;
use App\Models\Pagamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PagamentoResource extends Resource
{
    protected static ?string $model = Pagamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('agendamento_id')
                    ->relationship('agendamento', 'data_hora')
                    ->searchable(['paciente.nome', 'data_hora'])
                    ->getOptionLabelFromRecordUsing(fn(Agendamento $record) => $record->paciente->nome . ' - ' . $record->data_hora->format('d/m/Y H:i'))
                    ->required(),
                Forms\Components\TextInput::make('valor')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('forma_pagamento')
                    ->options([
                        'dinheiro' => 'Dinheiro',
                        'cartao_debito' => 'Cartão de Débito',
                        'cartao_credito' => 'Cartão de Crédito',
                        'pix' => 'PIX',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agendamento.paciente.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('agendamento.data_hora')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('valor')
                    ->money('BRL'),
                Tables\Columns\SelectColumn::make('forma_pagamento')
                    ->options([
                        'dinheiro' => 'Dinheiro',
                        'cartao_debito' => 'Cartão de Débito',
                        'cartao_credito' => 'Cartão de Crédito',
                        'pix' => 'PIX',
                    ]),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPagamentos::route('/'),
            'create' => Pages\CreatePagamento::route('/create'),
            'edit' => Pages\EditPagamento::route('/{record}/edit'),
        ];
    }
}
