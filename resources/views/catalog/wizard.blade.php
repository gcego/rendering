{{-- gcego-rendering::catalog.wizard — Wizard: the step list; each WizardStep renders its own section --}}
@php
    $heading = $ui->heading();
@endphp
<div{{ $ui->attributes(['aria-labelledby' => $heading !== null ? $ui->id('title') : null]) }}>
    @if ($heading !== null)
        <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
    @endif
    <ol{{ $ui->slot('steps') }}>
        @foreach ($ui->items() as $item)
            <li{{ $ui->slot('step', ['aria-current' => $item['active'] ? 'step' : null, 'data-active' => $item['active'] ? 'true' : null]) }}>
                <a{{ $ui->slot('step-link', ['href' => '#'.$item['id']]) }}>{{ $item['title'] }}</a>
            </li>
        @endforeach
    </ol>
    {{ $children }}
</div>
