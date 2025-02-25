<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContactSubmission extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'page_id'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'message'])
            ->setDescriptionForEvent(function(string $eventName) {
                return match($eventName) {
                    'created' => "Nouveau message de contact de {$this->name}",
                    default => "Action sur le message de contact de {$this->name}"
                };
            })
            ->useLogName('contact');
    }

    public function tapActivity($activity)
    {
        $activity->causer_id = null;
        $activity->causer_type = null;
    }
} 