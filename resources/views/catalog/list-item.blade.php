{{-- gcego-rendering::catalog.list-item — ListItem and TimelineItem --}}
@php
    $title = $ui->text('title') ?? $ui->text('label');
@endphp
<li{{ $ui->attributes() }}>
    @if ($ui->text('date') !== null)
        <span{{ $ui->slot('date') }}>{{ $ui->text('date') }}</span>
    @endif
    @if ($ui->text('icon') !== null)
        <span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>
    @endif
    @if ($title !== null)
        <p{{ $ui->slot('title') }}><strong>{{ $title }}</strong></p>
    @endif
    @if ($ui->text('description') !== null)
        <p{{ $ui->slot('description') }}>{{ $ui->text('description') }}</p>
    @endif
    {{ $children }}
</li>
