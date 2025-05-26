<x-app-layout>
    <x-event-list 
        :events="$events" 
        title="Agenda" 
        empty_message="Aucun événement à venir">
        <a href="{{ route('agenda-archives') }}" class="button inline-block px-6 py-3 text-sm font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all">
            Voir les événements passés
        </a>
    </x-event-list>
</x-app-layout> 