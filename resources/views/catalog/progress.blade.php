{{-- gcego-rendering::catalog.progress — Progress --}}
@php
    $max = $ui->get('max');
    $max = is_int($max) || is_float($max) ? $max : 100;
    $value = $ui->get('value');
    $value = is_int($value) || is_float($value) ? $value : null;
@endphp
<progress{{ $ui->attributes(['value' => $value, 'max' => $max, 'aria-label' => $ui->label()]) }}>{{ $value === null || $max == 0 ? '' : round($value / $max * 100).'%' }}</progress>
