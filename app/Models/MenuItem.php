<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'title',
        'url',
        'route_name',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getUrlAttribute($value)
    {
        if ($this->route_name) {
            return route($this->route_name);
        }
        return $value;
    }
} 