<?php

namespace App\Livewire\Front;

use App\Models\About;
use App\Models\Feature;
use Livewire\Component;

class AboutSection extends Component
{
    public $about;
    public $title;
    public $description_1, $description_2;
    public $aboutImage;
    public $features = [];

    public function mount()
    {
        $this->about = About::first();

        if ($this->about) {
            $this->title = $this->about->title;
            $this->description_1 = $this->about->description_1;
            $this->description_2 = $this->about->description_2;
            $this->aboutImage = $this->about->image;
            if ($this->about->features) {
                $features = $this->about->features;

                // Suporta tanto JSON string (dados antigos) quanto array (cast do model)
                if (is_string($features)) {
                    $features = json_decode($features, true) ?? [];
                }

                // A view usa sintaxe de objeto ($feature->icon)
                $this->features = array_map(fn ($f) => (object) $f, (array) $features);
            }
        }
    }

    public function render()
    {
        return view('livewire.front.about-section');
    }
}
