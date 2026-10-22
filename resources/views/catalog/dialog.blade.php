{{-- gcego-rendering::catalog.dialog — Modal and Drawer as a native dialog (open when Open is set) --}}
@php
    $heading = $ui->heading();
    $description = $ui->text('description');
@endphp
<dialog{{ $ui->attributes(['open' => $ui->flag('open'), 'aria-labelledby' => $heading !== null ? $ui->id('title') : null, 'aria-describedby' => $description !== null ? $ui->id('description') : null, 'data-dismissible' => $ui->flag('dismissible') ? 'true' : null]) }}>
    @if ($heading !== null || $ui->flag('dismissible'))
        <header{{ $ui->slot('header') }}>
            @if ($heading !== null)
                <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
            @endif
            @if ($ui->flag('dismissible'))
                <form method="dialog"{{ $ui->slot('close-form') }}>
                    <button{{ $ui->slot('close', ['type' => 'submit', 'aria-label' => 'Close']) }}><span aria-hidden="true">&times;</span></button>
                </form>
            @endif
        </header>
    @endif
    @if ($description !== null)
        <p{{ $ui->slot('description', ['id' => $ui->id('description')]) }}>{{ $description }}</p>
    @endif
    {{ $children }}
</dialog>
