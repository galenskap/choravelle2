<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\BelongsToTenant;

class File extends Model
{
    use HasFactory, LogsActivity, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'title',
        'song_id',
        'tenant_id',
        'sort_order',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(function(string $eventName) {
                return match($eventName) {
                    'created' => "a ajouté le fichier \"{$this->title}\"",
                    'updated' => "a modifié le fichier \"{$this->title}\"",
                    'deleted' => "a supprimé le fichier \"{$this->title}\"",
                    default => "a effectué une action sur le fichier \"{$this->title}\""
                };
            })
            ->useLogName('fichier');
    }

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($file) {
            // Valider la taille du fichier (64MB en octets)
            $maxSize = 64 * 1024 * 1024; 
            if ($file->size > $maxSize) {
                throw new \Exception('Le fichier est trop volumineux. La taille maximale est de 64MB.');
            }
        });
    }
}
