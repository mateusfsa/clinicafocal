<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsPanel extends Component
{
    use WithFileUploads;

    public $settings = [];
    public $successMessage = null;

    public function mount()
    {
        $this->settings = Setting::pluck('value', 'name')->toArray();
    }

    public function save()
    {
        foreach ($this->settings as $name => $value) {
            Setting::where('name', $name)->update(['value' => $value]);
        }

        $this->successMessage = 'Configurações atualizadas com sucesso!';
        // $this->emit('settingsUpdated');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.settings-panel');
    }
}
