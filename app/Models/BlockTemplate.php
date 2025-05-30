<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlockTemplate extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'preview_image',
    ];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }
} 