{{-- gcego-rendering::catalog.wizard-step — WizardStep: shown when it is the wizard's active step --}}
@php
    $heading = $ui->heading() ?? $ui->label();
    $description = $ui->text('description');
    $inWizard = $ui->parentType() === 'layout.wizard';
@endphp
<section{{ $ui->attributes(['aria-labelledby' => $heading !== null ? $ui->id('title') : null, 'hidden' => $inWizard && ! $ui->isActiveChild(), 'aria-disabled' => $ui->flag('disabled') ? 'true' : null]) }}>
    @if ($heading !== null)
        <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
    @endif
    @if ($description !== null)
        <p{{ $ui->slot('description') }}>{{ $description }}</p>
    @endif
    {{ $children }}
</section>
