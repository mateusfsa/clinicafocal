<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Hero::create([
            'title' => 'Bem-vindo à Clínica Focal',
            'subtitle' => 'Cuidando da sua saúde com excelência',
            'button1_text' => 'Agende uma Consulta',
            'button1_link' => '#contato',
            'button2_text' => 'Saiba Mais',
            'button2_link' => '#sobre',
            'background_image' => 'hero-section/i9N321dFE75THZIi2JMe3Gd1ZOrP5no1K3y3JJHU.jpg',
            'is_active' => true,
        ]);
    }
}
