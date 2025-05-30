<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'block_template_id',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class)
            ->withPivot('order');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(BlockTemplate::class, 'block_template_id');
    }

    public function getTemplateSlug(): string
    {
        if (!$this->template) {
            throw new \RuntimeException("Block template not found for block {$this->id}");
        }
        return $this->template;
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}
