<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendamentoResource\Pages;
use App\Filament\Resources\AgendamentoResource\RelationManagers;
use App\Filament\Resources\ProntuarioResource;
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
                Forms\Components\Select::make('medico_id')
                    ->label('Médico')
                    ->relationship('medico', 'nome', fn (Builder $query) => $query->where('ativo', true))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('convenio_id')
                    ->label('Convênio')
                    ->relationship('convenio', 'nome', fn (Builder $query) => $query->where('ativo', true))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Particular'),
                Forms\Components\DateTimePicker::make('data_hora')
                    ->required()
                    ->seconds(false)
                    ->rule(fn (Forms\Get $get, ?Agendamento $record) => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                        $medicoId = $get('medico_id');
                        if (! $medicoId || ! $value) {
                            return;
                        }
                        $conflito = Agendamento::query()
                            ->where('medico_id', $medicoId)
                            ->where('data_hora', $value)
                            ->when($record, fn ($q) => $q->whereKeyNot($record->getKey()))
                            ->exists();
                        if ($conflito) {
                            $fail('O médico já possui um agendamento neste horário.');
                        }
                    }),
                Forms\Components\Select::make('status')
                    ->options([
                        'agendado' => 'Agendado',
                        'compareceu' => 'Compareceu',
                        'em_atendimento' => 'Em Atendimento',
                        'finalizado' => 'Finalizado',
                        'cancelado' => 'Cancelado',
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
                Tables\Columns\TextColumn::make('medico.nome')
                    ->label('Médico')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('convenio.nome')
                    ->label('Convênio')
                    ->placeholder('Particular')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('data_hora')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'agendado',
                        'success' => 'compareceu',
                        'primary' => 'em_atendimento',
                        'danger' => 'finalizado',
                        'gray' => 'cancelado',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('medico_id')
                    ->label('Médico')
                    ->relationship('medico', 'nome'),
                Tables\Filters\SelectFilter::make('convenio_id')
                    ->label('Convênio')
                    ->relationship('convenio', 'nome'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'agendado' => 'Agendado',
                        'compareceu' => 'Compareceu',
                        'em_atendimento' => 'Em Atendimento',
                        'finalizado' => 'Finalizado',
                        'cancelado' => 'Cancelado',
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
                Tables\Actions\Action::make('prontuario')
                    ->label('Prontuário')
                    ->icon('heroicon-o-document-text')
                    ->visible(fn (Agendamento $record) => in_array($record->status, ['em_atendimento', 'finalizado'])
                        && (auth()->user()?->isMedico() || auth()->user()?->isAdmin()))
                    ->url(fn (Agendamento $record) => $record->prontuario
                        ? ProntuarioResource::getUrl('edit', ['record' => $record->prontuario])
                        : ProntuarioResource::getUrl('create', ['agendamento_id' => $record->id])),
                Tables\Actions\Action::make('cancelar')
                    ->label('Cancelar')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn(Agendamento $record) => $record->status === 'agendado')
                    ->action(function (Agendamento $record) {
                        $record->status = Agendamento::STATUS_CANCELADO;
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
