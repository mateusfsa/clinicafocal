<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceManager extends Component
{
    use WithFileUploads;

    public $services;
    public $serviceId;
    public $title;
    public $description;
    public $image;
    public $newImage;
    public $link;
    public $order = 0;
    public $active = true;
    public $isEdit = 0; // 0 = oculto, 1 = edit, 2 = add  

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1200',
        'newImage' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'link' => 'nullable|string|max:255',
        'order' => 'required|integer|min:0',
        'active' => 'boolean'
    ];

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = Service::orderBy('order')->get();
    }

    public function resetForm()
    {
        $this->serviceId = null;
        $this->title = '';
        $this->description = '';
        $this->image = null;
        $this->newImage = null;
        $this->link = '';
        $this->order = 0;
        $this->active = true;
        $this->isEdit = 0;
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->title = $service->title;
        $this->description = $service->description;
        $this->image = $service->image;
        $this->link = $service->link;
        $this->order = $service->order;
        $this->active = $service->active;
        $this->isEdit = 1;
    }
    public function addService()
    {
        $this->resetForm();
        $this->isEdit = 2; // Reset to add mode
    }

    public function toggleActive($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $service->active = !$service->active;
        $service->save();
        session()->flash('message', 'Status do service atualizado com sucesso.');
        $this->loadServices();
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->newImage) {
            $path = $this->newImage->store('services', 'public');
            $data['image'] = $this->newImage->store('services', 'public');
            $member->image = $path;
        } else if ($this->isEdit) {
            $data['image'] = $this->image;
        }        

        if ($this->isEdit && $this->serviceId) {
            Service::findOrFail($this->serviceId)->update($data);
            session()->flash('message', 'Serviço atualizado com sucesso!');
        } else {
            Service::create($data);
            session()->flash('message', 'Serviço criado com sucesso!');
        }

        $this->resetForm();
        $this->loadServices();
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image && \Storage::disk('public')->exists($service->image)) {
            \Storage::disk('public')->delete($service->image);
        }
        $service->delete();
        session()->flash('message', 'Serviço removido!');
        $this->resetForm();
        $this->loadServices();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.service-manager');
    }
}
