<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Block;
use App\Models\BlockTemplate;

return new class extends Migration
{
    public function up(): void
    {
        // Migrer les données existantes
        Block::all()->each(function ($block) {
            $template = BlockTemplate::where('slug', $block->template)->first();
            if ($template) {
                $block->block_template_id = $template->id;
                $block->save();
            }
        });
    }

    public function down(): void
    {
        // Optionnel : restaurer les anciennes valeurs si nécessaire
        Block::all()->each(function ($block) {
            $block->template = $block->template?->slug;
            $block->save();
        });
    }
}; 