<?php

namespace App\Models;

use App\Enum\BlockTemplatesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'content',
        'template',
    ];

    protected $casts = [
        'content' => 'array',
        'template' => BlockTemplatesEnum::class,
    ];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class)
            ->withPivot('order');
    }

    public function getTemplateCode()
    {
        return $this->template->value;
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}
