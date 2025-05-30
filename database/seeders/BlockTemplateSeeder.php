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
                'view_path' => 'editor',
            ],
            [
                'slug' => 'banner',
                'name' => 'Bannière',
                'view_path' => 'banner',
            ],
            [
                'slug' => 'cards',
                'name' => 'Cartes',
                'view_path' => 'cards',
            ],
            [
                'slug' => 'illustration',
                'name' => 'Illustration',
                'view_path' => 'illustration',
            ],
            [
                'slug' => 'icons',
                'name' => 'Icônes',
                'view_path' => 'icons',
            ],
            [
                'slug' => 'contact-form',
                'name' => 'Formulaire de contact',
                'view_path' => 'contact-form',
            ],
            [
                'slug' => 'agenda-repertoire',
                'name' => 'Agenda & Répertoire',
                'view_path' => 'agenda-repertoire',
            ],
        ];

        foreach ($templates as $template) {
            BlockTemplate::create($template);
        }
    }
} 