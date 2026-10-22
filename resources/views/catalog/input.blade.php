{{-- gcego-rendering::catalog.input — every single-line input: text, email, password, search, url, tel, number, range, date, datetime-local, time, color and file --}}
@php
    $type = match ($component->type()) {
        'inputs.emailInput' => 'email',
        'inputs.passwordInput' => 'password',
        'inputs.searchInput' => 'search',
        'inputs.urlInput' => 'url',
        'inputs.telInput' => 'tel',
        'inputs.numberInput' => 'number',
        'inputs.rangeInput' => 'range',
        'inputs.datePicker' => 'date',
        'inputs.dateTimePicker' => 'datetime-local',
        'inputs.timePicker' => 'time',
        'inputs.colorPicker' => 'color',
        'inputs.fileUpload' => 'file',
        default => 'text',
    };
    $multiple = $type === 'file' && $ui->flag('multiple');
    $accept = $ui->get('accept');
    $name = $ui->inputName();
@endphp
<div{{ $ui->slot('field', ['data-gcego-field' => $ui->statePath()]) }}>
    @include('gcego-rendering::catalog.partials-field-label', ['for' => $ui->id()])
    <input{{ $ui->attributes([
        'type' => $type,
        'name' => $name === null ? null : ($multiple ? $name.'[]' : $name),
        'value' => in_array($type, ['password', 'file'], true) ? null : $ui->valueText(),
        'placeholder' => $ui->text('placeholder'),
        'required' => $ui->flag('required'),
        'disabled' => $ui->flag('disabled'),
        'readonly' => $ui->flag('readOnly') && $type !== 'file',
        'autocomplete' => $ui->text('autocomplete'),
        'minlength' => $ui->integer('minLength'),
        'maxlength' => $ui->integer('maxLength'),
        'min' => $ui->text('min'),
        'max' => $ui->text('max'),
        'step' => $ui->text('step'),
        'accept' => is_array($accept) ? implode(',', $accept) : null,
        'multiple' => $multiple,
        'data-max-files' => $ui->integer('maxFiles'),
        'data-max-size' => $ui->integer('maxSize'),
        'data-format' => $ui->text('format'),
        'data-timezone' => $ui->text('timezone'),
        'aria-describedby' => $ui->describedBy(),
        ...$ui->wire(),
    ]) }}>
    @include('gcego-rendering::catalog.partials-field-hint')
</div>
