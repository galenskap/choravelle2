<x-app-layout>
    <x-event-list :events="collect([$event])" title="Détail de l'événement" :empty_message="'Événement non trouvé'" :back_link="['url' => route('agenda'), 'text' => 'Retour à l\'agenda']">
        <a href="{{ route('agenda') }}" class="block px-6 py-3 text-base font-semibold text-white bg-primary hover:bg-pink-700 rounded-lg transition-colors">
            Voir tout l'agenda
        </a>
    </x-event-list>
</x-app-layout> 