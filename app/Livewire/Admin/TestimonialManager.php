<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestimonialManager extends Component
{
    use WithFileUploads;

    public $testimonials, $name, $role, $testimonial, $image, $testimonial_id;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'role' => 'nullable|string|max:255',
        'testimonial' => 'required|string',
        'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ];

    public function mount()
    {
        $this->loadTestimonials();
    }

    public function loadTestimonials()
    {
        $this->testimonials = Testimonial::orderBy('id', 'desc')->get();
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->modalFormVisible = true;
    }

    public function showEditModal($id)
    {
        $item = Testimonial::findOrFail($id);
        $this->testimonial_id = $id;
        $this->name = $item->name;
        $this->role = $item->role;
        $this->testimonial = $item->testimonial;
        $this->modalFormVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->testimonial_id) {
            $item = Testimonial::find($this->testimonial_id);
        } else {
            $item = new Testimonial();
        }

        $item->fill([
            'name' => $this->name,
            'role' => $this->role,
            'testimonial' => $this->testimonial,
        ]);

        if ($this->image) {
            $path = $this->image->store('testimonials', 'public');
            $item->image = $path;
        }

        $item->save();

        $this->modalFormVisible = false;
        $this->resetForm();
        $this->loadTestimonials();
        session()->flash('message', 'Depoimento salvo com sucesso.');
    }

    public function confirmDelete($id)
    {
        $this->testimonial_id = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        Testimonial::destroy($this->testimonial_id);
        $this->modalConfirmDeleteVisible = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->testimonial_id = null;
        $this->name = '';
        $this->role = '';
        $this->testimonial = '';
        $this->image = null;
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.testimonial-manager');
    }
}
