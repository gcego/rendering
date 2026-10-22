{{-- gcego-rendering::catalog.partials-field-label — the label of a field: $for is the control id --}}
@if ($ui->label() !== null)
    <label{{ $ui->slot('label', ['for' => $for]) }}>{{ $ui->label() }}@if ($ui->flag('required'))<span{{ $ui->slot('required', ['aria-hidden' => 'true']) }}>*</span>@endif</label>
@endif
