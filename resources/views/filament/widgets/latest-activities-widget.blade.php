<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-2 mb-4">
            <x-heroicon-s-clock class="w-5 h-5 text-gray-500" />
            <h2 class="text-lg font-medium">Dernières actions</h2>
        </div>

        <div class="space-y-4">
            @forelse ($activities as $activity)
                <div class="flex items-start gap-2 p-2 rounded-lg transition hover:bg-gray-50">
                    <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-medium text-primary-700">
                            {{ substr($activity['user'], 0, 1) }}
                        </span>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">{{ $activity['user'] }}</span>
                            <span class="text-gray-500">{{ $activity['description'] }}</span>
                            @if($activity['subject_type'])
                                <span class="text-gray-500">({{ $activity['subject_type'] }})</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $activity['date'] }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">
                    Aucune activité enregistrée
                </p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget> 