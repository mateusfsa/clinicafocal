<?php

namespace App\Filament\Pages\Cms;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class ConfiguracoesSite extends BaseCmsPage implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Configurações do Site';
    protected static ?string $navigationLabel = 'Configurações';
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'site/configuracoes';

    protected static string $view = 'filament.pages.cms.form-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'settings' => Setting::pluck('value', 'name')->toArray(),
        ]);
    }

    public function form(Form $form): Form
    {
        // Campos gerados dinamicamente a partir das configurações existentes
        $campos = Setting::orderBy('name')->get()->map(function (Setting $setting) {
            $label = ucfirst(str_replace('_', ' ', $setting->name));

            if (mb_strlen((string) $setting->value) > 100) {
                return Forms\Components\Textarea::make("settings.{$setting->name}")
                    ->label($label)
                    ->rows(3);
            }

            return Forms\Components\TextInput::make("settings.{$setting->name}")
                ->label($label);
        })->all();

        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make('Configurações gerais')
                    ->description('Textos, contatos e demais opções usadas em todo o site.')
                    ->schema($campos)
                    ->columns(2),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data['settings'] ?? [] as $name => $value) {
            Setting::where('name', $name)->update(['value' => $value]);
        }

        Notification::make()->title('Configurações atualizadas.')->success()->send();
    }
}
