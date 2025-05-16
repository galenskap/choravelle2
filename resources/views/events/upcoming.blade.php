<x-app-layout>
    <x-event-list 
        :events="$events" 
        title="Agenda" 
        empty_message="Aucun événement à venir">
        <div class="mt-8 text-center">
            <a href="{{ route('agenda-archives') }}" class="text-blue-600 hover:text-blue-800">
                Voir les événements passés
            </a>
        </div>
    </x-event-list>
</x-app-layout> 