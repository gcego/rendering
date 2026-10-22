{{-- gcego-rendering::catalog.radio — Radio: a group of radio buttons --}}
<fieldset{{ $ui->attributes(['aria-describedby' => $ui->describedBy(), 'aria-required' => $ui->flag('required') ? 'true' : null, 'disabled' => $ui->flag('disabled'), 'data-gcego-field' => $ui->statePath()]) }}>
    @if ($ui->label() !== null)
        <legend{{ $ui->slot('label') }}>{{ $ui->label() }}@if ($ui->flag('required'))<span{{ $ui->slot('required', ['aria-hidden' => 'true']) }}>*</span>@endif</legend>
    @endif
    @foreach ($ui->options() as $index => $option)
        <label{{ $ui->slot('option') }}>
            <input{{ $ui->slot('input', [
                'type' => 'radio',
                'id' => $ui->id('option-'.$index),
                'name' => $ui->inputName(),
                'value' => $option['value'],
                'checked' => $option['selected'],
                'required' => $ui->flag('required'),
                ...$ui->wire(),
            ]) }}>{{ $option['label'] }}</label>
    @endforeach
    @include('gcego-rendering::catalog.partials-field-hint')
</fieldset>
