<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class File extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'title',
        'song_id',
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function pupitres(): BelongsToMany
    {
        return $this->belongsToMany(Pupitre::class);
    }

    public function getMimeTypeAttribute(): ?string
    {
        if (!$this->filename) {
            return null;
        }
        return Storage::disk('public')->mimeType($this->filename);
    }

    public function getDownloadLinkAttribute(): ?string
    {
        if (!$this->filename) {
            return null;
        }
        return Storage::disk('public')->url($this->filename);
    }
}
