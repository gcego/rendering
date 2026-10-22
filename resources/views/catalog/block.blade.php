{{-- gcego-rendering::catalog.block — Schema, Section, Group, Item, Container, Stack, Row, Column, Grid, Splitter, Card, Panel --}}
@php
    $heading = $ui->heading();
    $description = $ui->text('description');
    $icon = $ui->text('icon');
    $tag = match (true) {
        $ui->is('layout.card', 'layout.panel') => 'article',
        $heading !== null => 'section',
        default => 'div',
    };
@endphp
<{{ $tag }}{{ $ui->attributes(['aria-labelledby' => $heading !== null ? $ui->id('title') : null, 'aria-disabled' => $ui->flag('disabled') ? 'true' : null]) }}>
    @if ($heading !== null)
        <header{{ $ui->slot('header') }}>
            @if ($icon !== null)
                <span{{ $ui->slot('icon', ['data-icon' => $icon, 'aria-hidden' => 'true']) }}></span>
            @endif
            <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
            @if ($description !== null)
                <p{{ $ui->slot('description') }}>{{ $description }}</p>
            @endif
        </header>
    @elseif ($description !== null)
        <p{{ $ui->slot('description') }}>{{ $description }}</p>
    @endif
    {{ $children }}
</{{ $tag }}>
