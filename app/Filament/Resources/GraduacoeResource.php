<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GraduacoeResource\Pages;
use App\Filament\Resources\GraduacoeResource\RelationManagers;
use App\Models\Agendamento;
use App\Models\Graduacoe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GraduacoeResource extends Resource
{
    protected static ?string $model = Graduacoe::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('agendamento_id')
                    ->relationship('agendamento', 'data_hora')
                    ->searchable(['paciente.nome', 'data_hora'])
                    ->getOptionLabelFromRecordUsing(fn(Agendamento $record) => $record->paciente->nome . ' - ' . $record->data_hora->format('d/m/Y H:i'))
                    ->required(),

                Forms\Components\Fieldset::make('Longe - OD')
                    ->schema([
                        Forms\Components\TextInput::make('longe_od_esferico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('longe_od_cilindrico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('longe_od_eixo')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(180),
                    ])->columns(3),

                Forms\Components\Fieldset::make('Longe - OE')
                    ->schema([
                        Forms\Components\TextInput::make('longe_oe_esferico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('longe_oe_cilindrico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('longe_oe_eixo')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(180),
                    ])->columns(3),

                Forms\Components\Fieldset::make('Perto - OD')
                    ->schema([
                        Forms\Components\TextInput::make('perto_od_esferico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('perto_od_cilindrico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('perto_od_eixo')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(180),
                    ])->columns(3),

                Forms\Components\Fieldset::make('Perto - OE')
                    ->schema([
                        Forms\Components\TextInput::make('perto_oe_esferico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('perto_oe_cilindrico')
                            ->numeric()
                            ->step(0.25),
                        Forms\Components\TextInput::make('perto_oe_eixo')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(180),
                    ])->columns(3),

                Forms\Components\TextInput::make('adicao')
                    ->numeric()
                    ->step(0.25),

                Forms\Components\Textarea::make('observacoes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agendamento.paciente.nome'),
                Tables\Columns\TextColumn::make('agendamento.data_hora')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Imprimir')
                    ->icon('heroicon-o-printer')
                    ->url(fn(Graduacoe $record) => route('print.graduacao', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListGraduacoes::route('/'),
            'create' => Pages\CreateGraduacoe::route('/create'),
            'edit' => Pages\EditGraduacoe::route('/{record}/edit'),
        ];
    }
}
