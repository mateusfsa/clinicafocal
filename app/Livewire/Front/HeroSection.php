<?php

namespace App\Livewire\Front;

use App\Models\Hero;
use Livewire\Component;

class HeroSection extends Component
{
    public function render()
    {
        // Fallback: sem registro ativo, exibe conteúdo padrão
        // (personalizável em Admin → Site → Seção Principal)
        $hero = Hero::where('is_active', true)->latest()->first()
            ?? (object) [
                'title' => 'Cuidando da sua visão com excelência',
                'subtitle' => 'Atendimento oftalmológico completo, com tecnologia e uma equipe dedicada ao seu bem-estar.',
                'button1_text' => 'Agendar Consulta',
                'button1_link' => '#agendamento',
                'button2_text' => 'Nossos Serviços',
                'button2_link' => '#servicos',
                'background_image' => null,
            ];

        return view('livewire.front.hero-section', [
            'hero' => $hero,
        ]);
    }
}
