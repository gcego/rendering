{{-- gcego-rendering::catalog.partials-field-hint — the help text a control points to with aria-describedby --}}
@if ($ui->describedBy() !== null)
    <p{{ $ui->slot('hint', ['id' => $ui->describedBy()]) }}>{{ $ui->text('helpText') }}</p>
@endif
