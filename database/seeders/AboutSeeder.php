<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\About::create([
            'title' => 'Sobre Nossa Clínica',
            'description_1' => 'Fundada em 2005, a Clínica Focal é referência em oftalmologia, oferecendo tratamentos de ponta com profissionais altamente qualificados. Nossa missão é proporcionar saúde ocular com excelência e humanização.',
            'description_2' => 'Com unidades modernas e equipamentos de última geração, garantimos diagnósticos precisos e tratamentos eficazes para diversas conditions oculares.',
            'image' => 'images/centro-cirugico.jpeg',
            'features' => json_encode([
                [
                    'icon' => 'fas fa-eye',
                    'title' => 'Equipamentos Modernos',
                    'description' => 'Tecnologia de ponta para diagnósticos precisos'
                ],
                [
                    'icon' => 'fas fa-user-md',
                    'title' => 'Profissionais Qualificados',
                    'description' => 'Médicos especializados e experientes'
                ],
                [
                    'icon' => 'fas fa-heart',
                    'title' => 'Atendimento Humanizado',
                    'description' => 'Cuidado personalizado para cada paciente'
                ],
                [
                    'icon' => 'fas fa-calendar-check',
                    'title' => 'Agilidade no Atendimento',
                    'description' => 'Consultas rápidas e exames no mesmo dia'
                ]
            ]),
        ]);
    }
}
