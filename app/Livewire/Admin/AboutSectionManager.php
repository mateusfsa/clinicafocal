<?php

namespace App\Livewire\Admin;

use App\Models\About;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutSectionManager extends Component
{
    use WithFileUploads;

    public $about;
    public $title;
    public $description_1;
    public $description_2;
    public $image;
    public $newImage;
    public $features = [];
     public $editMode = 0;

    public function mount()
    {
        $this->about = About::first() ?? new About();
        $this->title = $this->about->title;
        $this->description_1 = $this->about->description_1;
        $this->description_2 = $this->about->description_2;
        $this->image = $this->about->image;
        $this->features =  json_decode($this->about->features) ?? [];
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description_1' => 'required|string',
            'description_2' => 'nullable|string',
            'newImage' => 'nullable|image|max:1024', // Máx 1MB
            'features' => 'nullable|array',
        ]);

        if ($this->newImage) {
            $this->image = $this->newImage->store('about', 'public');
        }

        $this->about->updateOrCreate(
            ['id' => $this->about->id],
            [
                'title' => $this->title,
                'description_1' => $this->description_1,
                'description_2' => $this->description_2,
                'image' => $this->image,
                'features' => $this->features,
            ]
        );

        session()->flash('message', 'Seção atualizada com sucesso!');
    }

    public function addFeature()
    {
        $this->features[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features); // Reorganiza os índices
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.about-section-manager');
    }
}
