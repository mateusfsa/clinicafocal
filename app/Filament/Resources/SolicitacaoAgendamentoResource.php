<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitacaoAgendamentoResource\Pages;
use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\SolicitacaoAgendamento;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SolicitacaoAgendamentoResource extends Resource
{
    protected static ?string $model = SolicitacaoAgendamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Atendimento';

    protected static ?string $modelLabel = 'Solicitação de Agendamento';

    protected static ?string $pluralModelLabel = 'Solicitações de Agendamento';

    public static function getNavigationBadge(): ?string
    {
        $pendentes = SolicitacaoAgendamento::pendentes()->count();

        return $pendentes > 0 ? (string) $pendentes : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('nome'),
                Infolists\Components\TextEntry::make('email')
                    ->label('E-mail'),
                Infolists\Components\TextEntry::make('telefone'),
                Infolists\Components\TextEntry::make('medico.nome')
                    ->label('Médico')
                    ->placeholder('Sem preferência'),
                Infolists\Components\TextEntry::make('data_preferida')
                    ->label('Data preferida')
                    ->date('d/m/Y'),
                Infolists\Components\TextEntry::make('periodo')
                    ->label('Período')
                    ->formatStateUsing(fn (string $state) => $state === 'manha' ? 'Manhã' : 'Tarde'),
                Infolists\Components\TextEntry::make('mensagem')
                    ->placeholder('—')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pendente' => 'warning',
                        'confirmada' => 'success',
                        'recusada' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\TextColumn::make('medico.nome')
                    ->label('Médico')
                    ->placeholder('Sem preferência'),
                Tables\Columns\TextColumn::make('data_preferida')
                    ->label('Data preferida')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('periodo')
                    ->label('Período')
                    ->formatStateUsing(fn (string $state) => $state === 'manha' ? 'Manhã' : 'Tarde'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pendente',
                        'success' => 'confirmada',
                        'danger' => 'recusada',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recebida em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'confirmada' => 'Confirmada',
                        'recusada' => 'Recusada',
                    ])
                    ->default('pendente'),
            ])
            ->actions([
                Tables\Actions\Action::make('confirmar')
                    ->label('Confirmar')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (SolicitacaoAgendamento $record) => $record->status === SolicitacaoAgendamento::STATUS_PENDENTE)
                    ->form(fn (SolicitacaoAgendamento $record) => [
                        Forms\Components\Select::make('medico_id')
                            ->label('Médico')
                            ->options(\App\Models\Medico::ativos()->orderBy('nome')->pluck('nome', 'id'))
                            ->default($record->medico_id)
                            ->required(),
                        Forms\Components\DateTimePicker::make('data_hora')
                            ->label('Data e hora da consulta')
                            ->seconds(false)
                            ->default($record->data_preferida?->setTime($record->periodo === 'manha' ? 9 : 14, 0))
                            ->required(),
                    ])
                    ->action(function (SolicitacaoAgendamento $record, array $data) {
                        // Reaproveita paciente existente (por e-mail) ou cria um pré-cadastro
                        $paciente = Paciente::where('email', $record->email)->first();

                        if (! $paciente) {
                            $paciente = Paciente::create([
                                'nome' => $record->nome,
                                'email' => $record->email,
                                'telefone' => $record->telefone,
                                // Pré-cadastro: completar no atendimento
                                'data_nascimento' => now()->toDateString(),
                                'cpf' => 'PEND-' . $record->id,
                                'observacoes' => 'Pré-cadastro via agendamento online. Completar CPF e data de nascimento.',
                                // Consentimento dado no formulário online
                                'consentimento_lgpd' => $record->consentimento,
                            ]);
                        }

                        $conflito = Agendamento::query()
                            ->where('medico_id', $data['medico_id'])
                            ->where('data_hora', $data['data_hora'])
                            ->exists();

                        if ($conflito) {
                            Notification::make()
                                ->title('O médico já possui um agendamento neste horário.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $agendamento = Agendamento::create([
                            'paciente_id' => $paciente->id,
                            'medico_id' => $data['medico_id'],
                            'data_hora' => $data['data_hora'],
                            'status' => Agendamento::STATUS_AGENDADO,
                        ]);

                        $record->update([
                            'status' => SolicitacaoAgendamento::STATUS_CONFIRMADA,
                            'agendamento_id' => $agendamento->id,
                        ]);

                        Notification::make()
                            ->title('Agendamento criado com sucesso.')
                            ->body('Lembre-se de avisar o paciente por telefone/WhatsApp.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('recusar')
                    ->label('Recusar')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn (SolicitacaoAgendamento $record) => $record->status === SolicitacaoAgendamento::STATUS_PENDENTE)
                    ->action(fn (SolicitacaoAgendamento $record) => $record->update([
                        'status' => SolicitacaoAgendamento::STATUS_RECUSADA,
                    ])),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolicitacaoAgendamentos::route('/'),
        ];
    }
}
