{{-- gcego-rendering::catalog.chart — Chart: data for a client-side chart, with a data table for assistive technology --}}
@php
    $pairs = $ui->pairs();
@endphp
<figure{{ $ui->attributes(['data-chart' => $ui->json('data'), 'data-options' => $ui->get('options') === null ? null : $ui->json('options')]) }}>
    @if ($ui->label() !== null)
        <figcaption{{ $ui->slot('caption') }}>{{ $ui->label() }}</figcaption>
    @endif
    <div{{ $ui->slot('canvas', ['aria-hidden' => 'true']) }}></div>
    @if ($pairs !== [])
        <table{{ $ui->slot('data') }}>
            <tbody>
                @foreach ($pairs as $key => $value)
                    <tr><th scope="row">{{ $key }}</th><td>{{ $value }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif
</figure>
