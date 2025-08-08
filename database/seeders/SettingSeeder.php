<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Default Settings
        DB::table('settings')->insert([
            [
                'name' => 'title_site',
                'value' => 'Clinica Focal',
            ],
            [
                'name' => 'logo_site',
                'value' => '/images/logo_olho.png',
            ],
            [
                'name' => 'about_section_title',
                'value' => 'Sobre Nossa Clínica',
            ],
            [
                'name' => 'about_section_description',
                'value' => 'Nossa clínica é dedicada a oferecer o melhor atendimento médico com profissionais qualificados.',
            ],
            [
                'name' => 'service_section_title',
                'value' => 'Nossos Serviços',
            ],
            [
                'name' => 'service_section_subtitle',
                'value' => 'Oferecemos tratamentos oftalmológicos completos para todas as idades e necessidades',
            ],
            [
                'name' => 'team_section_title',
                'value' => 'Nossa Equipe',
            ],
            [
                'name' => 'team_section_subtitle',
                'value' => 'Profissionais altamente qualificados dedicados ao cuidado da sua visão',
            ],
            [
                'name' => 'testimonial_section_title',
                'value' => 'Depoimentos de Pacientes',
            ],
            [
                'name' => 'testimonial_section_subtitle',
                'value' => 'Veja o que nossos pacientes dizem sobre nós',
            ],
            [
                'name' => 'contact_section_title',
                'value' => 'Entre em Contato Conosco',
            ],
            [
                'name' => 'contact_section_subtitle',
                'value' => 'Estamos aqui para ajudar com qualquer dúvida ou agendamento',
            ],
            [
                'name' => 'contact_section_address',
                'value' => 'Rua Exemplo, 123, Bairro <br> Cidade, Estado, CEP',
            ],
            [
                'name' => 'contact_section_phone',
                'value' => '(11) 1234-5678',
            ],
            [
                'name' => 'contact_section_email',
                'value' => '',
            ],
            [
                'name' => 'contact_section_time_1',
                'value' => '',
            ],
            [
                'name' => 'contact_section_time_2',
                'value' => '',
            ],
            [
                'name' => 'whatsapp',
                'value' => '759999-9999'
            ],

            [
                'name' => 'footer_text',
                'value' => '© 2025 Clinica Focal. Todos os direitos reservados.',
            ],
            [
                'name' => 'facebook',
                'value' => ''
            ],
            [
                'name' => 'instagram',
                'value' => ''
            ],
            [
                'name' => 'linkedin',
                'value' => ''
            ]
        ]);
    }
}
