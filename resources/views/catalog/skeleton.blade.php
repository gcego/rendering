{{-- gcego-rendering::catalog.skeleton — Skeleton: a loading placeholder --}}
<div{{ $ui->attributes(['role' => 'status', 'aria-busy' => 'true', 'aria-label' => $ui->text('label') ?? 'Loading']) }}>
    @for ($line = 0; $line < max(1, $ui->integer('rows') ?? 1); $line++)
        <span{{ $ui->slot('line', ['aria-hidden' => 'true']) }}></span>
    @endfor
</div>
