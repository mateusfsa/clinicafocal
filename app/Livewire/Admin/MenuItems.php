<?php

namespace App\Livewire\Admin;

use App\Models\MenuItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MenuItems extends Component
{
    public $items = [];
    public $editMode = 0;
    public $newItem = [
        'label' => '',
        'url' => '',
        'order' => 0,
        'is_active' => true
    ];

    protected $rules = [
        'items.*.label' => 'required|string|max:255',
        'items.*.url' => 'required|string|max:255',
        'items.*.order' => 'required|integer',
        'items.*.is_active' => 'boolean',
        'newItem.label' => 'required|string|max:255',
        'newItem.url' => 'required|string|max:255',
        'newItem.order' => 'required|integer',
        'newItem.is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->loadMenuItems();
    }

    public function toggleActive($itemId)
    {
        $item = MenuItem::findOrFail($itemId);
        $item->is_active = !$item->is_active;
        $item->save();
        session()->flash('message', 'Status do item atualizado com sucesso.');
        $this->loadMenuItems();
    }
    
    public function loadMenuItems()
    {
        $this->items = MenuItem::ordered()->get()->toArray();
    }

    public function addItem()
    {
        $this->validate([
            'newItem.label' => 'required|string|max:255',
            'newItem.url' => 'required|string|max:255',
            'newItem.order' => 'required|integer',
        ]);

        MenuItem::create($this->newItem);
        $this->mount();
        $this->newItem = [
            'label' => '',
            'url' => '',
            'order' => count($this->items) + 1,
            'is_active' => true
        ];
    }

    public function updateItems()
    {
        $this->validate([
            'items.*.label' => 'required|string|max:255',
            'items.*.url' => 'required|string|max:255',
            'items.*.order' => 'required|integer',
            'items.*.is_active' => 'boolean',
        ]);

        foreach ($this->items as $item) {
            MenuItem::find($item['id'])->update($item);
        }

        session()->flash('message', 'Menu atualizado com sucesso!');
    }

    public function deleteItem($id)
    {
        MenuItem::find($id)->delete();
        $this->mount();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.menu-items');
    }
}
