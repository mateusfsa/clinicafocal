<?php

namespace App\Livewire\Front\Components;

use App\Models\About;
use App\Models\MenuItem;
use App\Models\Service;
use Livewire\Component;

class Footer extends Component
{
    public $services, $menuItems = [];
    public $about;

    public function mount()
    {
        $this->services = Service::get();
        $this->menuItems = MenuItem::active()->ordered()->get();
        $this->about = About::first();
    }
    public function render()
    {
        return view('livewire.front.components.footer');
    }
}
