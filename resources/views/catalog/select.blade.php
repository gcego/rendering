{{-- gcego-rendering::catalog.select — Select and MultiSelect --}}
@php
    $multiple = $ui->is('inputs.multiSelect');
    $name = $ui->inputName();
@endphp
<div{{ $ui->slot('field', ['data-gcego-field' => $ui->statePath()]) }}>
    @include('gcego-rendering::catalog.partials-field-label', ['for' => $ui->id()])
    <select{{ $ui->attributes([
        'name' => $name === null ? null : ($multiple ? $name.'[]' : $name),
        'multiple' => $multiple,
        'required' => $ui->flag('required'),
        'disabled' => $ui->flag('disabled'),
        'aria-readonly' => $ui->flag('readOnly') ? 'true' : null,
        'autocomplete' => $ui->text('autocomplete'),
        'data-searchable' => $ui->flag('searchable') ? 'true' : null,
        'aria-describedby' => $ui->describedBy(),
        ...$ui->wire(),
    ]) }}>
        @if (! $multiple && $ui->text('placeholder') !== null)
            <option{{ $ui->slot('option', ['value' => '']) }}>{{ $ui->text('placeholder') }}</option>
        @endif
        @foreach ($ui->options() as $option)
            <option{{ $ui->slot('option', ['value' => $option['value'], 'selected' => $option['selected']]) }}>{{ $option['label'] }}</option>
        @endforeach
    </select>
    @include('gcego-rendering::catalog.partials-field-hint')
</div>
