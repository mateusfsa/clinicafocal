<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProntuarioResource\Pages;
use App\Models\Agendamento;
use App\Models\Prontuario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProntuarioResource extends Resource
{
    protected static ?string $model = Prontuario::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Atendimento';

    protected static ?string $modelLabel = 'Prontuário';

    protected static ?string $pluralModelLabel = 'Prontuários';

    /**
     * Prontuário é restrito a médicos e administradores (LGPD: controle de acesso).
     */
    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user && ($user->isMedico() || $user->isAdmin());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('agendamento_id')
                    ->label('Atendimento')
                    ->relationship('agendamento', 'data_hora')
                    ->getOptionLabelFromRecordUsing(fn (Agendamento $record) => $record->paciente->nome . ' - ' . $record->data_hora->format('d/m/Y H:i'))
                    ->searchable(['data_hora'])
                    ->preload()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => request()->integer('agendamento_id') ?: null)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Anamnese')
                    ->schema([
                        Forms\Components\Textarea::make('queixa_principal')
                            ->label('Queixa principal')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('historia_doenca')
                            ->label('História da doença atual')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('antecedentes')
                            ->label('Antecedentes pessoais e familiares')
                            ->rows(2),
                        Forms\Components\Textarea::make('medicamentos_em_uso')
                            ->label('Medicamentos em uso')
                            ->rows(2),
                        Forms\Components\Textarea::make('alergias')
                            ->rows(2),
                    ])->columns(2),

                Forms\Components\Section::make('Exame Oftalmológico')
                    ->schema([
                        Forms\Components\Fieldset::make('Acuidade visual (sem correção)')
                            ->schema([
                                Forms\Components\TextInput::make('av_od_sc')
                                    ->label('OD')
                                    ->placeholder('20/20')
                                    ->maxLength(10),
                                Forms\Components\TextInput::make('av_oe_sc')
                                    ->label('OE')
                                    ->placeholder('20/20')
                                    ->maxLength(10),
                            ])->columns(2),
                        Forms\Components\Fieldset::make('Acuidade visual (com correção)')
                            ->schema([
                                Forms\Components\TextInput::make('av_od_cc')
                                    ->label('OD')
                                    ->placeholder('20/20')
                                    ->maxLength(10),
                                Forms\Components\TextInput::make('av_oe_cc')
                                    ->label('OE')
                                    ->placeholder('20/20')
                                    ->maxLength(10),
                            ])->columns(2),
                        Forms\Components\Fieldset::make('Tonometria - PIO (mmHg)')
                            ->schema([
                                Forms\Components\TextInput::make('pio_od')
                                    ->label('OD')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(99)
                                    ->step('0.1'),
                                Forms\Components\TextInput::make('pio_oe')
                                    ->label('OE')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(99)
                                    ->step('0.1'),
                            ])->columns(2),
                        Forms\Components\Textarea::make('biomicroscopia')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('fundoscopia')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Diagnóstico e Conduta')
                    ->schema([
                        Forms\Components\Textarea::make('diagnostico')
                            ->label('Diagnóstico')
                            ->rows(2),
                        Forms\Components\TextInput::make('cid')
                            ->label('CID-10')
                            ->placeholder('H52.1')
                            ->maxLength(10),
                        Forms\Components\Textarea::make('conduta')
                            ->label('Conduta / Evolução')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('agendamento.paciente.nome')
                    ->label('Paciente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agendamento.medico.nome')
                    ->label('Médico')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('agendamento.data_hora')
                    ->label('Atendimento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('diagnostico')
                    ->label('Diagnóstico')
                    ->limit(40)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('cid')
                    ->label('CID')
                    ->placeholder('—'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProntuarios::route('/'),
            'create' => Pages\CreateProntuario::route('/create'),
            'edit' => Pages\EditProntuario::route('/{record}/edit'),
        ];
    }
}
