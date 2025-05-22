<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trombinoscope') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($pupitres as $pupitre)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">{{ $pupitre->name }}</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($pupitre->users as $user)
                                <div class="flex flex-col items-center">
                                    @if($user->profile_photo_path)
                                        <img src="{{ Storage::url($user->profile_photo_path) }}" 
                                             alt="{{ $user->name }}"
                                             class="w-32 h-32 rounded-full object-cover mb-2"
                                             height="128"
                                             width="128">
                                    @else
                                        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-2">
                                            <span class="text-3xl text-gray-600">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <span class="text-center font-medium">{{ $user->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endsection

</x-app-layout>