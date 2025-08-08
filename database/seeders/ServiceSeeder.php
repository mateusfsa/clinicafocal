<?php
// database/seeders/ServiceSeeder.php
namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Exame de Vista Completo',
                'description' => 'Avaliação completa da saúde ocular com equipamentos modernos para detecção precoce de problemas.',
                'image' => null,
                'link' => '#exame-vista',
                'order' => 1,
                'active' => true,
            ],
            [
                'title' => 'Consulta Oftalmológica',
                'description' => 'Consulta com oftalmologista para diagnóstico e tratamento de doenças oculares.',
                'image' => null,
                'link' => '#consulta-oftalmo',
                'order' => 2,
                'active' => true,
            ],
            [
                'title' => 'Cirurgia de Catarata',
                'description' => 'Procedimento cirúrgico para remoção da catarata, melhorando a visão do paciente.',
                'image' => null,
                'link' => '#cirurgia-catarata',
                'order' => 3,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
