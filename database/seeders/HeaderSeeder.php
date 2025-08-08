<?php

namespace Database\Seeders;

use App\Livewire\Front\Components\Header;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::create([
            ['label' => 'Início', 'url' => '#inicio'],
            ['label' => 'Sobre Nós', 'url' => '#sobre'],
            ['label' => 'Serviços', 'url' => '#servicos'],
            ['label' => 'Equipe', 'url' => '#equipe'],
            ['label' => 'Depoimentos', 'url' => '#depoimentos'],
            ['label' => 'Contato', 'url' => '#contato'],
        ]);
    }
}
