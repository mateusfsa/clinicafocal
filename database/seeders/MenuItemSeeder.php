<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['label' => 'Início', 'url' => '#inicio', 'order' => 1, 'is_active' => true],
            ['label' => 'Sobre Nós', 'url' => '#sobre', 'order' => 2, 'is_active' => true],
            ['label' => 'Serviços', 'url' => '#servicos', 'order' => 3, 'is_active' => true],
            ['label' => 'Equipe', 'url' => '#equipe', 'order' => 4, 'is_active' => true],
            ['label' => 'Depoimentos', 'url' => '#depoimentos', 'order' => 5, 'is_active' => true],
            ['label' => 'Contato', 'url' => '#contato', 'order' => 6, 'is_active' => true],
        ];
        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
