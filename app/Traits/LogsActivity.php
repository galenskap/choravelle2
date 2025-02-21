<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('created', $model);
        });

        static::updated(function ($model) {
            self::logActivity('updated', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('deleted', $model);
        });
    }

    protected static function logActivity(string $action, $model)
    {
        if (!auth()->check()) return;

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'description' => self::getActivityDescription($action, $model),
        ]);
    }

    protected static function getActivityDescription(string $action, $model): string
    {
        $modelName = class_basename($model);
        return match ($action) {
            'created' => "a créé {$modelName} #{$model->id}",
            'updated' => "a modifié {$modelName} #{$model->id}",
            'deleted' => "a supprimé {$modelName} #{$model->id}",
            default => "a effectué une action sur {$modelName} #{$model->id}",
        };
    }
} 