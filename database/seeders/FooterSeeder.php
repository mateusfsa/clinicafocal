<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run()
    {
        Footer::create([
            'about' => 'Cuidando da sua visão com excelência e tecnologia desde 2005. Oferecemos tratamentos oftalmológicos completos com profissionais altamente qualificados.',
            'quick_links' => [
                ['title' => 'Início', 'url' => '#inicio'],
                ['title' => 'Sobre Nós', 'url' => '#sobre'],
                ['title' => 'Serviços', 'url' => '#servicos'],
                ['title' => 'Equipe', 'url' => '#equipe'],
                ['title' => 'Depoimentos', 'url' => '#depoimentos'],
                ['title' => 'Contato', 'url' => '#contato'],
            ],
            'services' => [
                ['title' => 'Exame de Vista', 'url' => '#'],
                ['title' => 'Cirurgia de Catarata', 'url' => '#'],
                ['title' => 'Cirurgia Refrativa', 'url' => '#'],
                ['title' => 'Tratamento de Glaucoma', 'url' => '#'],
                ['title' => 'Oftalmopediatria', 'url' => '#'],
                ['title' => 'Retina e Vítreo', 'url' => '#'],
            ],
            'copyright_text' => 'Clínica Focal. Todos os direitos reservados.',
            'social_links' => [
                ['icon' => 'facebook-f', 'url' => '#'],
                ['icon' => 'instagram', 'url' => '#'],
                ['icon' => 'linkedin-in', 'url' => '#'],
                ['icon' => 'youtube', 'url' => '#'],
            ],
            'newsletter_active' => true,
        ]);        
    }
}
