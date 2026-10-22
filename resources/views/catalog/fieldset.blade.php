{{-- gcego-rendering::catalog.fieldset — Fieldset --}}
@php
    $heading = $ui->heading();
    $description = $ui->text('description');
@endphp
<fieldset{{ $ui->attributes(['disabled' => $ui->flag('disabled'), 'aria-describedby' => $description !== null ? $ui->id('description') : null]) }}>
    @if ($heading !== null)
        <legend{{ $ui->slot('legend') }}>{{ $heading }}</legend>
    @endif
    @if ($description !== null)
        <p{{ $ui->slot('description', ['id' => $ui->id('description')]) }}>{{ $description }}</p>
    @endif
    {{ $children }}
</fieldset>
