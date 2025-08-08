<?php

// database/seeders/ContactInfoSeeder.php
namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    public function run()
    {
        ContactInfo::create([
            'type' => 'address',
            'title' => 'Endereço',
            'content' => "Av. Paulista, 1000 - Bela Vista\nSão Paulo - SP, 01310-100",
            'icon' => 'fas fa-map-marker-alt',
            'order' => 1,
            'active' => true,
        ]);

        ContactInfo::create([
            'type' => 'phone',
            'title' => 'Telefone',
            'content' => "(11) 1234-5678\n(11) 98765-4321 (WhatsApp)",
            'icon' => 'fas fa-phone-alt',
            'order' => 2,
            'active' => true,
        ]);

        ContactInfo::create([
            'type' => 'email',
            'title' => 'Email',
            'content' => 'contato@visaoclara.com.br',
            'icon' => 'far fa-envelope',
            'order' => 3,
            'active' => true,
        ]);

        ContactInfo::create([
            'type' => 'hours',
            'title' => 'Horário de Funcionamento',
            'content' => "Segunda a Sexta: 8h às 19h\nSábado: 8h às 13h",
            'icon' => 'far fa-clock',
            'order' => 4,
            'active' => true,
        ]);
    }
}