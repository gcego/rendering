{{-- gcego-rendering::catalog.checkbox — Checkbox and Toggle (role="switch") --}}
@php
    $state = $ui->value();
    $checked = $ui->statePath() !== null && $state !== null ? (bool) $state : $ui->flag('checked');
@endphp
<div{{ $ui->slot('field', ['data-gcego-field' => $ui->statePath()]) }}>
    @if (! $context->isLivewire() && $ui->inputName() !== null)
        <input type="hidden" name="{{ $ui->inputName() }}" value="0">
    @endif
    <input{{ $ui->attributes([
        'type' => 'checkbox',
        'role' => $ui->is('inputs.toggle') ? 'switch' : null,
        'name' => $ui->inputName(),
        'value' => '1',
        'checked' => $checked,
        'required' => $ui->flag('required'),
        'disabled' => $ui->flag('disabled'),
        'aria-readonly' => $ui->flag('readOnly') ? 'true' : null,
        'aria-describedby' => $ui->describedBy(),
        ...$ui->wire(),
    ]) }}>
    @include('gcego-rendering::catalog.partials-field-label', ['for' => $ui->id()])
    @include('gcego-rendering::catalog.partials-field-hint')
</div>
