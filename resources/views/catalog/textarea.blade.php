{{-- gcego-rendering::catalog.textarea — Textarea, RichEditor and CodeEditor (editors enhance it client-side) --}}
<div{{ $ui->slot('field', ['data-gcego-field' => $ui->statePath()]) }}>
    @include('gcego-rendering::catalog.partials-field-label', ['for' => $ui->id()])
    <textarea{{ $ui->attributes([
        'name' => $ui->inputName(),
        'rows' => $ui->integer('rows'),
        'placeholder' => $ui->text('placeholder'),
        'required' => $ui->flag('required'),
        'disabled' => $ui->flag('disabled'),
        'readonly' => $ui->flag('readOnly'),
        'autocomplete' => $ui->text('autocomplete'),
        'minlength' => $ui->integer('minLength'),
        'maxlength' => $ui->integer('maxLength'),
        'spellcheck' => $ui->is('inputs.codeEditor') ? 'false' : null,
        'data-editor' => match ($component->type()) { 'inputs.richEditor' => 'rich', 'inputs.codeEditor' => 'code', default => null },
        'data-language' => $ui->text('language'),
        'aria-describedby' => $ui->describedBy(),
        ...$ui->wire(),
    ]) }}>{{ $ui->valueText() }}</textarea>
    @include('gcego-rendering::catalog.partials-field-hint')
</div>
