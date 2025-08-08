<?php

namespace App\Livewire\Front;

use App\Models\Testimonial;
use Livewire\Component;

class TestimonialSection extends Component
{

    public $testimonials = [];

    public function mount()
    {
        $this->loadTestimonials();
    }

    public function loadTestimonials()
    {
        $this->testimonials = Testimonial::orderBy('id', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.front.testimonial-section');
    }
}
