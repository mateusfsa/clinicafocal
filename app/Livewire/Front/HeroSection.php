<?php

namespace App\Livewire\Front;

use App\Models\Hero;
use Livewire\Component;

class HeroSection extends Component
{
    public $hero;    

    public function mount()
    {
        $this->hero = Hero::where('is_active', true)->latest()->first();
    }

    public function render()
    {
        return view('livewire.front.hero-section', [
            'hero' => $this->hero
        ]);
    }
}
