{{-- gcego-rendering::catalog.stat — Stat: a labelled value --}}
<dl{{ $ui->attributes() }}>
    <dt{{ $ui->slot('label') }}>@if ($ui->text('icon') !== null)<span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>@endif{{ $ui->label() }}</dt>
    <dd{{ $ui->slot('value') }}>{{ $ui->text('value') ?? $ui->text('content') }}</dd>
    @if ($ui->text('description') !== null)
        <dd{{ $ui->slot('description') }}>{{ $ui->text('description') }}</dd>
    @endif
</dl>
