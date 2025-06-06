<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\BelongsToTenant;

class Folder extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'name',
        'is_current',
        'order',
        'tenant_id',
    ];

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class)
            ->withPivot('order')
            ->orderByPivot('order');
    }
}
