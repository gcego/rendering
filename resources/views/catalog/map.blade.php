{{-- gcego-rendering::catalog.map — Map: coordinates for a client-side map, with a text fallback --}}
@php
    $latitude = $ui->text('latitude');
    $longitude = $ui->text('longitude');
@endphp
<figure{{ $ui->attributes(['data-latitude' => $latitude, 'data-longitude' => $longitude, 'data-zoom' => $ui->text('zoom')]) }}>
    <div{{ $ui->slot('canvas', ['role' => 'img', 'aria-label' => 'Map at latitude '.($latitude ?? '?').', longitude '.($longitude ?? '?')]) }}></div>
    @if ($ui->label() !== null)
        <figcaption{{ $ui->slot('caption') }}>{{ $ui->label() }}</figcaption>
    @endif
</figure>
