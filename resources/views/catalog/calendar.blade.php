{{-- gcego-rendering::catalog.calendar — Calendar: events for a client-side calendar, listed for assistive technology --}}
@php
    $events = $ui->get('events');
@endphp
<section{{ $ui->attributes(['data-events' => $ui->json('events'), 'aria-label' => $ui->label() ?? 'Calendar']) }}>
    @if (is_array($events) && $events !== [])
        <ul{{ $ui->slot('events') }}>
            @foreach ($events as $event)
                @php
                    $title = is_array($event) && is_scalar($event['title'] ?? null) ? (string) $event['title'] : null;
                    $start = is_array($event) && is_scalar($event['start'] ?? null) ? (string) $event['start'] : null;
                @endphp
                @if ($title !== null)
                    <li{{ $ui->slot('event') }}>{{ $title }}@if ($start !== null) <span{{ $ui->slot('event-start') }}>{{ $start }}</span>@endif</li>
                @endif
            @endforeach
        </ul>
    @endif
</section>
