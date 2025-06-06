<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\BelongsToTenant;

class Pupitre extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'name',
        'tenant_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }
}
