<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendamentoResource\Pages;
use App\Filament\Resources\AgendamentoResource\RelationManagers;
use App\Models\Agendamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgendamentoResource extends Resource
{
    protected static ?string $model = Agendamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paciente_id')
                    ->relationship('paciente', 'nome')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('data_hora')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'agendado' => 'Agendado',
                        'compareceu' => 'Compareceu',
                        'em_atendimento' => 'Em Atendimento',
                        'finalizado' => 'Finalizado',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_hora')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'agendado',
                        'success' => 'compareceu',
                        'primary' => 'em_atendimento',
                        'danger' => 'finalizado',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'agendado' => 'Agendado',
                        'compareceu' => 'Compareceu',
                        'em_atendimento' => 'Em Atendimento',
                        'finalizado' => 'Finalizado',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('checkin')
                    ->label('Check-in')
                    ->visible(fn(Agendamento $record) => $record->status === 'agendado')
                    ->action(function (Agendamento $record) {
                        $record->status = 'compareceu';
                        $record->save();
                    }),
                Tables\Actions\Action::make('iniciar_atendimento')
                    ->label('Iniciar Atendimento')
                    ->visible(fn(Agendamento $record) => $record->status === 'compareceu')
                    ->action(function (Agendamento $record) {
                        $record->status = 'em_atendimento';
                        $record->save();
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
            'index' => Pages\ListAgendamentos::route('/'),
            'create' => Pages\CreateAgendamento::route('/create'),
            'edit' => Pages\EditAgendamento::route('/{record}/edit'),
        ];
    }
}
