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
                    <div class="flex items-center text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">
                        <div class="flex-1 px-6">Titre</div>
                        <div class="flex-1 px-6 hidden md:block">Auteur</div>
                        <div class="flex-1 px-6 hidden sm:block">Dernière modification</div>
                        <div class="w-24 px-6 md:block hidden">Actions</div>
                    </div>

                    <!-- List -->
                    <div class="divide-y divide-gray-200">
                        @foreach($partitions as $partition)
                            <a href="{{ route('partition', $partition) }}" class="partition-row block hover:bg-gray-50 transition duration-150">
                                <div class="flex items-center py-4">
                                    <div class="flex-1 px-6">
                                        <div class="text-base font-medium text-gray-900" data-search="title">
                                            {{ $partition->title }}
                                        </div>
                                        <!-- Mobile: auteur et date sur la même ligne -->
                                        <div class="flex gap-2 items-center mt-1 md:hidden">
                                            @if($partition->author)
                                                <div class="text-[18px] text-gray-500" data-search="author">
                                                    {{ $partition->author }}
                                                </div>
                                                <div class="text-xs text-gray-400">•</div>
                                            @endif
                                            <div class="text-xs text-gray-500">
                                                {{ max($partition->updated_at, $partition->files->max('updated_at'))->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1 px-6 hidden md:block">
                                        <div class="text-base text-gray-500" data-search="author">
                                            {{ $partition->author }}
                                        </div>
                                    </div>
                                    <div class="flex-1 px-6 hidden sm:block">
                                        <div class="text-base text-gray-500">
                                            {{ max($partition->updated_at, $partition->files->max('updated_at'))->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="w-24 px-6 hidden md:block">
                                        <span class="inline-block px-6 py-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                                            Voir
                                        </span>
                                    </div>
                                    <!-- Flèche à droite sur mobile -->
                                    <div class="md:hidden pr-4">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>