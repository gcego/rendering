{{-- gcego-rendering::catalog.accordion — Accordion; each AccordionItem renders a disclosure --}}
@php
    $heading = $ui->heading();
@endphp
<div{{ $ui->attributes(['aria-labelledby' => $heading !== null ? $ui->id('title') : null]) }}>
    @if ($heading !== null)
        <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
    @endif
    {{ $children }}
</div>
