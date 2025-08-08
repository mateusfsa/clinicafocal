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
                $this->features = json_decode($this->about->features);
            }
        }
    }

    public function render()
    {
        return view('livewire.front.about-section');
    }
}
