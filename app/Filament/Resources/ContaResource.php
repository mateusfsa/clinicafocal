<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContaResource\Pages;
use App\Models\Conta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContaResource extends Resource
{
    protected static ?string $model = Conta::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?string $modelLabel = 'Conta';

    protected static ?string $pluralModelLabel = 'Contas a Pagar/Receber';

    public static function getNavigationBadge(): ?string
    {
        $vencidas = Conta::vencidas()->count();

        return $vencidas > 0 ? (string) $vencidas : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo')
                    ->options([
                        'pagar' => 'A pagar',
                        'receber' => 'A receber',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('descricao')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('categoria')
                    ->maxLength(50)
                    ->datalist([
                        'Aluguel',
                        'Salários',
                        'Fornecedores',
                        'Energia/Água/Internet',
                        'Impostos',
                        'Equipamentos',
                        'Repasse de convênio',
                        'Consulta particular',
                        'Outros',
                    ]),
                Forms\Components\TextInput::make('valor')
                    ->label('Valor (R$)')
                    ->numeric()
                    ->minValue(0.01)
                    ->step('0.01')
                    ->required(),
                Forms\Components\DatePicker::make('vencimento')
                    ->required(),
                Forms\Components\Select::make('paciente_id')
                    ->label('Paciente (origem do recebível)')
                    ->relationship('paciente', 'nome')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->visible(fn (Forms\Get $get) => $get('tipo') === 'receber'),
                Forms\Components\Select::make('convenio_id')
                    ->label('Convênio (origem do recebível)')
                    ->relationship('convenio', 'nome')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->visible(fn (Forms\Get $get) => $get('tipo') === 'receber'),
                Forms\Components\Textarea::make('observacoes')
                    ->label('Observações')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('vencimento', 'asc')
            ->columns([
                Tables\Columns\BadgeColumn::make('tipo')
                    ->colors([
                        'danger' => 'pagar',
                        'success' => 'receber',
                    ])
                    ->formatStateUsing(fn (string $state) => $state === 'pagar' ? 'A pagar' : 'A receber'),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable()
                    ->limit(35),
                Tables\Columns\TextColumn::make('categoria')
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('valor')
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format((float) $state, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('vencimento')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'paga' => 'success',
                        'vencida' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'pagar' => 'A pagar',
                        'receber' => 'A receber',
                    ]),
                Tables\Filters\TernaryFilter::make('quitada')
                    ->label('Situação')
                    ->placeholder('Todas')
                    ->trueLabel('Pagas')
                    ->falseLabel('Em aberto')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('pago_em'),
                        false: fn (Builder $query) => $query->whereNull('pago_em'),
                    ),
                Tables\Filters\Filter::make('vencidas')
                    ->label('Somente vencidas')
                    ->query(fn (Builder $query) => $query->vencidas()),
            ])
            ->actions([
                Tables\Actions\Action::make('quitar')
                    ->label('Marcar como paga')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Conta $record) => $record->pago_em === null)
                    ->form([
                        Forms\Components\DatePicker::make('pago_em')
                            ->label('Data do pagamento')
                            ->default(today())
                            ->required(),
                        Forms\Components\Select::make('forma_pagamento')
                            ->label('Forma de pagamento')
                            ->options([
                                'dinheiro' => 'Dinheiro',
                                'cartao_debito' => 'Cartão de Débito',
                                'cartao_credito' => 'Cartão de Crédito',
                                'pix' => 'PIX',
                                'transferencia' => 'Transferência',
                                'boleto' => 'Boleto',
                            ]),
                    ])
                    ->action(fn (Conta $record, array $data) => $record->update($data)),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContas::route('/'),
            'create' => Pages\CreateConta::route('/create'),
            'edit' => Pages\EditConta::route('/{record}/edit'),
        ];
    }
}
