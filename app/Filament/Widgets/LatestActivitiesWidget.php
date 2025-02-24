<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Spatie\Activitylog\Models\Activity;

class LatestActivitiesWidget extends Widget
{
    protected static string $view = 'filament.widgets.latest-activities-widget';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'activities' => Activity::with('causer')
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($activity) {
                    return [
                        'user' => $activity->causer?->name ?? 'Système',
                        'description' => $activity->description,
                        'subject_type' => class_basename($activity->subject_type),
                        'date' => $activity->created_at->diffForHumans(),
                    ];
                }),
        ];
    }
} 