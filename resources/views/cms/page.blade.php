@extends('layouts.app')

@section('content')

    @if (!$page->isHomepage())
    <h1 class="page-title">{{ $page->title }}</h1>
    @endif

    @foreach ($blocks as $block)
        @include('cms.blocks.' . $block->getTemplateCode(), ['content' => $block->content, 'slug' => $block->slug])
    @endforeach

@endsection