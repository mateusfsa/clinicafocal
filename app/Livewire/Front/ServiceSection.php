<?php

namespace App\Livewire\Front;

use Livewire\Component;

class ServiceSection extends Component
{

    public $services;

    public function mount()
    {
        $this->services = \App\Models\Service::orderBy('order')->get();
    }
    public function render()
    {
        return view('livewire.front.service-section');
    }
}
