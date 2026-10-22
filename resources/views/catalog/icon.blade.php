{{-- gcego-rendering::catalog.icon — Icon: decorative unless it has a label --}}
@php
    $label = $ui->text('label');
@endphp
<span{{ $ui->attributes(['data-icon' => $ui->text('icon'), 'role' => $label !== null ? 'img' : null, 'aria-label' => $label, 'aria-hidden' => $label === null ? 'true' : null]) }}></span>
