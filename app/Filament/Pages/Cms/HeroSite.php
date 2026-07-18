<?php

namespace App\Filament\Pages\Cms;

use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class HeroSite extends BaseCmsPage implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Seção Principal (Hero)';
    protected static ?string $navigationLabel = 'Seção Principal';
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'site/hero';

    protected static string $view = 'filament.pages.cms.form-page';

    public ?array $data = [];

    public function mount(): void
    {
        $hero = Hero::first();

        // Sem registro: fill() sem argumentos aplica os defaults do form
        $hero ? $this->form->fill($hero->toArray()) : $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make('Conteúdo')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('subtitle')
                            ->label('Subtítulo')
                            ->rows(2),
                        Forms\Components\FileUpload::make('background_image')
                            ->label('Imagem de fundo')
                            ->image()
                            ->disk('public')
                            ->directory('hero-section'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Seção ativa')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('Botões')
                    ->schema([
                        Forms\Components\TextInput::make('button1_text')
                            ->label('Botão 1 — texto'),
                        Forms\Components\TextInput::make('button1_link')
                            ->label('Botão 1 — link'),
                        Forms\Components\TextInput::make('button2_text')
                            ->label('Botão 2 — texto'),
                        Forms\Components\TextInput::make('button2_link')
                            ->label('Botão 2 — link'),
                    ])->columns(2),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $hero = Hero::first();
        $hero ? $hero->update($data) : Hero::create($data);

        Notification::make()->title('Seção principal atualizada.')->success()->send();
    }
}
