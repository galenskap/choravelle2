<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToTenant;

class MenuItem extends Model
{
    use BelongsToTenant;
    
    protected $fillable = [
        'title',
        'url',
        'route_name',
        'order',
        'is_active',
        'is_private',
        'parent_id',
        'tenant_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_private' => 'boolean'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function getUrlAttribute($value)
    {
        if ($this->route_name) {
            if (str_starts_with($this->route_name, 'page.show/')) {
                $slug = substr($this->route_name, strlen('page.show/'));
                return route('page.show', ['slug' => $slug]);
            }
            return route($this->route_name);
        }
        return $value;
    }

    public static function getMenu()
    {
        return static::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }

    public function isAccessibleBy($user = null)
    {
        if (!$this->is_private) {
            return true;
        }
        
        return $user && $user->isAuthenticated();
    }

    public function isActive()
    {
        return request()->url() === $this->url;
    }
} 