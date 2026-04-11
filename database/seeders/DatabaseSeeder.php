<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@oficina.com'], [
            'name' => 'Admin',
            'password' => Hash::make('admin123'),
        ]);

        $settings = [
            'site_name'       => 'Oficina Mecânica',
            'hero_title'      => 'Sua oficina de confiança',
            'hero_subtitle'   => 'Qualidade e agilidade no seu veículo',
            'about_text'      => 'Somos uma oficina especializada com mais de 10 anos de experiência.',
            'whatsapp'        => '5511999999999',
            'instagram'       => 'https://instagram.com/suaoficina',
            'address'         => 'Rua Exemplo, 123 - São Paulo/SP',
            'phone'           => '(11) 99999-9999',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        $services = [
            ['title' => 'Revisão Geral', 'description' => 'Revisão completa do seu veículo.', 'icon' => '🔧'],
            ['title' => 'Troca de Óleo', 'description' => 'Troca de óleo e filtros.', 'icon' => '🛢️'],
            ['title' => 'Freios', 'description' => 'Manutenção e troca de freios.', 'icon' => '🚗'],
            ['title' => 'Suspensão', 'description' => 'Alinhamento e balanceamento.', 'icon' => '⚙️'],
        ];

        foreach ($services as $i => $s) {
            Service::firstOrCreate(['title' => $s['title']], array_merge($s, ['order' => $i]));
        }
    }
}
