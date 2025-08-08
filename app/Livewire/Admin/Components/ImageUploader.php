<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $image;
    public $uploadedImageUrl;

    protected $rules = [
        'image' => 'required|image|max:2048', // 2MB máximo
    ];

    public function updatedImage()
    {
        $this->validateOnly('image');
    }

    public function save()
    {
        $this->validate();

        // Salva a imagem no diretório storage/app/public/images
        $path = $this->image->store('images', 'public');

        // Converte para URL pública
        $this->uploadedImageUrl = asset('storage/' . $path);
    }

    public function removeImage()
    {
        $this->reset(['image', 'uploadedImageUrl']);
    }


    public function render()
    {
        return view('livewire.admin.components.image-uploader');
    }
}
