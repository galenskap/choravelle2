<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Song extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'lyrics',
        'comment',
        'show_on_home',
    ];

    protected $casts = [
        'show_on_home' => 'boolean',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function folders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class)
            ->withPivot('order')
            ->orderByPivot('order');
    }

    public function getFilesGroupedByPupitreAttribute(): Collection
    {
        // Récupérer tous les fichiers avec leurs pupitres
        $files = $this->files()->with('pupitres')->get();
        
        // Initialiser le résultat avec le groupe "Tutti"
        $tutti = $files->filter(function ($file) {
            return $file->pupitres->isEmpty();
        });
        
        // Grouper les autres fichiers par pupitre
        $byPupitre = collect();
        $files->each(function ($file) use (&$byPupitre) {
            $file->pupitres->each(function ($pupitre) use ($file, &$byPupitre) {
                if (!isset($byPupitre[$pupitre->name])) {
                    $byPupitre[$pupitre->name] = collect();
                }
                $byPupitre[$pupitre->name]->push($file);
            });
        });
        
        // Combiner "Tutti" avec les autres pupitres triés
        return collect(['Tutti' => $tutti])
            ->merge($byPupitre->sortKeys())
            ->filter->isNotEmpty();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'author', 'lyrics', 'comment'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('song');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return match($eventName) {
            'created' => "a créé la chanson \"{$this->title}\"",
            'updated' => "a modifié la chanson \"{$this->title}\"",
            'deleted' => "a supprimé la chanson \"{$this->title}\"",
            default => "a effectué une action sur la chanson \"{$this->title}\""
        };
    }
}
