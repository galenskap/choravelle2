@extends('layouts.app')

@section('content')
<div class="error-page px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto text-center">
        <h1 class="text-xl font-bold text-pink-600">{{ __('errors.404.code') }}</h1>
        
        <div class="mt-4">
            <h2 class="text-2xl font-semibold text-gray-900">
                {{ __('errors.404.title') }}
            </h2>
            
            <p class="text-lg text-gray-600 mt-8">
                {{ __('errors.404.message') }}
            </p>

            <div class="mt-8 bottom-actions">
                <a href="/" class="inline-flex items-center px-4 py-2 text-base font-medium text-white bg-pink-600 hover:bg-pink-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('common.back_to_home') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 