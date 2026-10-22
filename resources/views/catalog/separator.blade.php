{{-- gcego-rendering::catalog.separator — Separator --}}
@if ($ui->text('orientation') === 'vertical')
    <div{{ $ui->attributes(['role' => 'separator', 'aria-orientation' => 'vertical']) }}></div>
@else
    <hr{{ $ui->attributes() }}>
@endif
