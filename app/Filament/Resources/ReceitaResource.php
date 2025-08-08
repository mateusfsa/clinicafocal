<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceitaResource\Pages;
use App\Filament\Resources\ReceitaResource\RelationManagers;
use App\Models\Agendamento;
use App\Models\Receita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceitaResource extends Resource
{
    protected static ?string $model = Receita::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('agendamento_id')
                    ->relationship('agendamento', 'data_hora')
                    ->searchable(['paciente.nome', 'data_hora'])
                    ->getOptionLabelFromRecordUsing(fn(Agendamento $record) => $record->paciente->nome . ' - ' . $record->data_hora->format('d/m/Y H:i'))
                    ->required(),
                Forms\Components\Textarea::make('medicamentos')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('instrucoes')
                    ->required()
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
                    ->url(fn(Receita $record) => route('print.receita', $record))
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
            'index' => Pages\ListReceitas::route('/'),
            'create' => Pages\CreateReceita::route('/create'),
            'edit' => Pages\EditReceita::route('/{record}/edit'),
        ];
    }
}
