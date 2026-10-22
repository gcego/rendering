{{-- gcego-rendering::catalog.hidden — HiddenInput --}}
<input{{ $ui->attributes(['type' => 'hidden', 'name' => $ui->inputName(), 'value' => $ui->valueText(), ...$ui->wire()]) }}>
