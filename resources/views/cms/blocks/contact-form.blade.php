<script src="https://js.hcaptcha.com/1/api.js" async defer></script>

<section id="{{ $slug }}" class="contact wrapper">
    <div class="content max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-4 text-xl">
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="h2 text-center mb-8 text-2xl">{{ $content['title'] }}</h2>

        @if($content['text'])
            <p class="text-center mb-8">{!! $content['text'] !!}</p>
        @endif
        
        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="page_id" value="{{ $page->id }}">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="name" id="name" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" name="phone" id="phone" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="4" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"></textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="h-captcha" data-sitekey="{{ config('services.hcaptcha.sitekey') }}"></div>
            @error('h-captcha-response')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="flex justify-center">
                <button type="submit" class="w-full md:w-auto px-6 py-3 text-lg font-semibold text-white bg-pink-600 hover:bg-pink-700 rounded-lg transition-colors">
                    {{ __('Envoyer') }}
                </button>
            </div>
        </form>
    </div>
</section> 