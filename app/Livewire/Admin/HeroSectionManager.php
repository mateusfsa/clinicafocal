<?php

namespace App\Livewire\Admin;

use App\Models\Hero;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class HeroSectionManager extends Component
{
    use WithFileUploads;

    public $heroes;
    public $title, $subtitle, $button1_text, $button1_link, $button2_text, $button2_link, $background_image, $is_active;
    public $heroId;
    public $editMode = 0;

    /**
     * New background image for the hero section.
     * This will be used to upload a new image when editing or adding a hero.
     */

    public $newBackgroundImage;

    protected $rules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'required|string|max:255',
        'button1_text' => 'required|string|max:255',
        'button1_link' => 'required|string|max:255',
        'button2_text' => 'nullable|string|max:255',
        'button2_link' => 'nullable|string|max:255',
        'newBackgroundImage' => 'nullable|image|max:2048', // Assuming image upload
        'is_active' => 'boolean'
    ];

    public function mount()
    {
        $this->loadHeroes();
    }

    public function addHero()
    {
        $this->resetForm();
        $this->editMode = 2; // Reset to add mode
    }

    public function editHero($heroId)
    {
        $this->resetForm();
        $hero = Hero::findOrFail($heroId);
        $this->heroId = $hero->id;
        $this->title = $hero->title;
        $this->subtitle = $hero->subtitle;
        $this->button1_text = $hero->button1_text;
        $this->button1_link = $hero->button1_link;
        $this->button2_text = $hero->button2_text;
        $this->button2_link = $hero->button2_link;
        $this->background_image = $hero->background_image;
        $this->is_active = $hero->is_active;
        $this->editMode = 1;
    }
    public function saveHero()
    {

        //$this->validate();

        $imagePath = $this->background_image;
        if ($this->newBackgroundImage) {
            if ($this->background_image) {
                Storage::delete('public/' . $this->background_image);
            }
            $imagePath = $this->newBackgroundImage->store('hero-section', 'public');
        }

        if ($this->editMode == 1) {
            $hero = Hero::find($this->heroId);
            $hero->update([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'button1_text' => $this->button1_text,
                'button1_link' => $this->button1_link,
                'button2_text' => $this->button2_text,
                'button2_link' => $this->button2_link,
                'background_image' => $imagePath,
                'is_active' => $this->is_active
            ]);
        } else {
            Hero::create([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'button1_text' => $this->button1_text,
                'button1_link' => $this->button1_link,
                'button2_text' => $this->button2_text,
                'button2_link' => $this->button2_link,
                'background_image' => $imagePath,
                'is_active' => 1
            ]);
        }      

        session()->flash('message', 'Hero salvo com sucesso.');
        $this->resetForm();
        $this->loadHeroes();
    }

    public function loadHeroes()
    {
        $this->heroes = Hero::orderBy('id', 'DESC')->get();
    }

    public function deleteHero($heroId)
    {
        $hero = Hero::findOrFail($heroId);
        $hero->delete();
        session()->flash('message', 'Hero deletado com sucesso.');
        $this->loadHeroes();
    }
    public function toggleActive($heroId)
    {       
        $hero = Hero::findOrFail($heroId);
        $hero->is_active = !$hero->is_active;
        $hero->save();
        session()->flash('message', 'Status do Hero atualizado com sucesso.');
        $this->loadHeroes();
    }

    public function resetForm()
    {
        $this->editMode = 0;
        $this->reset([
            'title',
            'subtitle',
            'button1_text',
            'button1_link',
            'button2_text',
            'button2_link',
            'newBackgroundImage',
            'is_active'
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.hero-section-manager', [
            'heroes' => $this->heroes
        ]);
    }
}
