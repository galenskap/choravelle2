<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;
use Filament\Panel;
use Filament\Contracts\FilamentUser;
class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;
    use CausesActivity;
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'pupitre_id',
        'is_active',
        'is_admin',
        'email_notifications',
        'last_read_timestamp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
            'email_notifications' => 'boolean',
            'last_read_timestamp' => 'datetime',
        ];
    }

    public function pupitre(): BelongsTo
    {
        return $this->belongsTo(Pupitre::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        Log::info('canAccessPanel called for user: ' . $this->email);
        return true;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('user');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return match($eventName) {
            'created' => "a créé l'utilisateur \"{$this->name}\"",
            'updated' => "a modifié l'utilisateur \"{$this->name}\"",
            'deleted' => "a supprimé l'utilisateur \"{$this->name}\"",
            default => "a effectué une action sur l'utilisateur \"{$this->name}\""
        };
    }
}
