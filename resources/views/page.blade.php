@foreach($blocks as $block)
    {!! \App\Filament\Blocks\AgendaRepertoireBlock::render($block) !!}
@endforeach 