<x-app-layout>
    <x-event-list 
        :events="$events" 
        title="Événements passés" 
        empty_message="Aucun événement passé"
        :back_link="['url' => route('agenda'), 'text' => 'Retour à l\'agenda']">
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </x-event-list>
</x-app-layout> 