{{-- gcego-rendering::catalog.list — ListView (unordered) and Timeline (ordered) --}}
@php
    $tag = $ui->is('display.timeline') ? 'ol' : 'ul';
@endphp
<{{ $tag }}{{ $ui->attributes(['aria-label' => $ui->text('label')]) }}>{{ $children }}</{{ $tag }}>
