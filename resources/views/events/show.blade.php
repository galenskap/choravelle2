<x-app-layout>
    <x-event-list :events="collect([$event])" title="Détail de l'événement" :empty_message="'Événement non trouvé'" :back_link="['url' => route('agenda'), 'text' => 'Retour à l\'agenda']">
        <a href="{{ route('agenda') }}" class="button block px-6 py-3 text-base font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all">
            Voir tout l'agenda
        </a>
    </x-event-list>
</x-app-layout> 