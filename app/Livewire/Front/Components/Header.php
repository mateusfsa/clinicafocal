<?php

namespace App\Livewire\Front\Components;

use App\Models\MenuItem;
use Livewire\Component;

class Header extends Component
{
    public $menuItems;
    public $logoText = 'Clínica';
    public $logoHighlight = 'Focal';
    public $isMenuOpen = false;

    public function mount()
    {
        $this->loadMenuItems();
    }

    public function loadMenuItems()
    {
        $this->menuItems = MenuItem::active()->ordered()->get();
    }

    public function toggleMenu()
    {
        $this->isMenuOpen = !$this->isMenuOpen;
    }


    public function render()
    {
        return view('livewire.front.components.header');
    }
}
