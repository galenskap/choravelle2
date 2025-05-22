<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class Event extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'date',
        'time',
        'location',
        'description',
        'members_only'
    ];

    protected $casts = [
        'date' => 'date',
        'members_only' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        Carbon::setLocale('fr');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'date', 'time', 'location', 'description', 'members_only'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return match($eventName) {
                    'created' => "a créé l'événement \"{$this->title}\"",
                    'updated' => "a modifié l'événement \"{$this->title}\"",
                    'deleted' => "a supprimé l'événement \"{$this->title}\"",
                    default => $eventName
                };
            });
    }
} 