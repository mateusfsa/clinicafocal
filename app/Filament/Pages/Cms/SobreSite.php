<?php

namespace App\Filament\Pages\Cms;

use App\Models\About;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class SobreSite extends BaseCmsPage implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Seção Sobre';
    protected static ?string $navigationLabel = 'Sobre';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'site/sobre';

    protected static string $view = 'filament.pages.cms.form-page';

    public ?array $data = [];

    public function mount(): void
    {
        $about = About::first();
        $estado = $about?->toArray() ?? [];

        // features pode estar salvo como JSON string
        if (isset($estado['features']) && is_string($estado['features'])) {
            $estado['features'] = json_decode($estado['features'], true) ?? [];
        }

        $this->form->fill($estado);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_1')
                    ->label('Descrição (1º parágrafo)')
                    ->rows(3),
                Forms\Components\Textarea::make('description_2')
                    ->label('Descrição (2º parágrafo)')
                    ->rows(3),
                Forms\Components\FileUpload::make('image')
                    ->label('Imagem')
                    ->image()
                    ->disk('public')
                    ->directory('about'),
                Forms\Components\Repeater::make('features')
                    ->label('Destaques')
                    ->schema([
                        Forms\Components\TextInput::make('icon')
                            ->label('Ícone (ex.: fas fa-eye)'),
                        Forms\Components\TextInput::make('title')
                            ->label('Título'),
                        Forms\Components\TextInput::make('description')
                            ->label('Descrição'),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('Adicionar destaque'),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $about = About::first();
        $about ? $about->update($data) : About::create($data);

        Notification::make()->title('Seção Sobre atualizada.')->success()->send();
    }
}
