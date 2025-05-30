<?php

namespace Database\Seeders;

use App\Models\BlockTemplate;
use Illuminate\Database\Seeder;

class BlockTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'slug' => 'editor',
                'name' => 'Éditeur de texte',
            ],
            [
                'slug' => 'banner',
                'name' => 'Bannière',
            ],
            [
                'slug' => 'cards',
                'name' => 'Cartes',
            ],
            [
                'slug' => 'illustration',
                'name' => 'Illustration',
            ],
            [
                'slug' => 'icons',
                'name' => 'Icônes',
            ],
            [
                'slug' => 'contact-form',
                'name' => 'Formulaire de contact',
            ],
            [
                'slug' => 'agenda-repertoire',
                'name' => 'Agenda & Répertoire',
            ],
        ];

        foreach ($templates as $template) {
            BlockTemplate::create($template);
        }
    }
} 