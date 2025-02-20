<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Partitions') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search Section -->
                    <div class="mb-6">
                        <input type="text" 
                               id="search" 
                               placeholder="Rechercher une partition..." 
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <!-- Header -->
                    <div class="flex items-center text-xs font-medium text-gray-500 uppercase tracking-wider mb-4">
                        <div class="flex-1 px-6">Titre</div>
                        <div class="flex-1 px-6">Auteur</div>
                        <div class="flex-1 px-6">Dernière modification</div>
                        <div class="w-24 px-6">Actions</div>
                    </div>

                    <!-- List -->
                    <div class="divide-y divide-gray-200">
                        @foreach($partitions as $partition)
                            <div class="partition-row flex items-center py-4 hover:bg-gray-50">
                                <div class="flex-1 px-6">
                                    <div class="text-sm font-medium text-gray-900" data-search="title">
                                        {{ $partition->title }}
                                    </div>
                                </div>
                                <div class="flex-1 px-6">
                                    <div class="text-sm text-gray-500" data-search="author">
                                        {{ $partition->author }}
                                    </div>
                                </div>
                                <div class="flex-1 px-6">
                                    <div class="text-sm text-gray-500">
                                        {{ $partition->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="w-24 px-6">
                                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">Voir</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>