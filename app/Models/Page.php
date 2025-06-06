<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\BelongsToTenant;

class Page extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'is_published',
        'tenant_id',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_published' => 'boolean',
    ];

    public function isHomepage()
    {
        return $this->slug === 'home';
    }

    public function blocks(): BelongsToMany
    {
        return $this->belongsToMany(Block::class)
            ->withPivot('order')
            ->orderByPivot('order', 'asc');
    }
}
