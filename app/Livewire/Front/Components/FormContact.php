<?php

namespace App\Livewire\Front\Components;

use App\Mail\ContactFormMail;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class FormContact extends Component
{
    public $services = [];
    public $name, $email, $phone, $service, $mensage;

    public function mount()
    {
        $this->services = Service::get();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:45',
        'service' => 'required|string|max:255',
        'mensage' => 'required|string|max:255',
    ];

    public function enviarEmail()
    {
        // Validação opcional aqui       
        $this->validate();
        Mail::to(get_option('contact_section_email'))->send(
            new ContactFormMail(
                $this->name,
                $this->email,
                $this->phone,
                $this->service,
                $this->mensage
            )
        );

        // Opcional: Limpar campos ou emitir evento para feedback
        $this->reset(['name', 'email', 'phone', 'service', 'mensage']);
        session()->flash('success', 'Mensagem enviada com sucesso!');
    }

    public function render()
    {
        return view('livewire.front.components.form-contact');
    }
}
