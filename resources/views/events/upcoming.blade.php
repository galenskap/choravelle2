<x-app-layout>
    <x-event-list 
        :events="$events" 
        title="Agenda" 
        empty_message="Aucun événement à venir">
        <a href="{{ route('agenda-archives') }}" class="inline-block px-6 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
            Voir les événements passés
        </a>
    </x-event-list>
</x-app-layout> 