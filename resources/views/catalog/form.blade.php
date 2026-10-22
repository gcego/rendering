{{-- gcego-rendering::catalog.form — Form: GET and POST submit natively; other methods are spoofed with _method --}}
@php
    $method = $ui->text('method') ?? 'POST';
    $nativeMethod = $method === 'GET' ? 'GET' : 'POST';
    $heading = $ui->heading();
@endphp
<form{{ $ui->attributes(['method' => $nativeMethod, 'action' => $ui->url('action'), 'aria-labelledby' => $heading !== null ? $ui->id('title') : null]) }}>
    @if ($heading !== null)
        <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
    @endif
    @if ($ui->text('description') !== null)
        <p{{ $ui->slot('description') }}>{{ $ui->text('description') }}</p>
    @endif
    @if ($nativeMethod === 'POST' && $ui->csrfToken() !== null)
        <input type="hidden" name="_token" value="{{ $ui->csrfToken() }}">
    @endif
    @if (! in_array($method, ['GET', 'POST'], true))
        <input type="hidden" name="_method" value="{{ $method }}">
    @endif
    @if ($ui->flag('disabled'))
        <fieldset disabled{{ $ui->slot('fields') }}>{{ $children }}</fieldset>
    @else
        {{ $children }}
    @endif
</form>
