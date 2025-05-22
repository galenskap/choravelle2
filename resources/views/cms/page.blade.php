@extends('layouts.app')

@section('content')

@if (!$page->isHomepage())
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
            <h1 class="page-title text-2xl font-bold">{{ $page->title }}</h1>
            
            @foreach ($blocks as $block)
                @include('cms.blocks.' . $block->getTemplateCode(), ['content' => $block->content, 'slug' => $block->slug])
            @endforeach
        </div>
    </div>
</div>

@else 
    @foreach ($blocks as $block)
        @include('cms.blocks.' . $block->getTemplateCode(), ['content' => $block->content, 'slug' => $block->slug])
    @endforeach
@endif

@endsection