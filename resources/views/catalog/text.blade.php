{{-- gcego-rendering::catalog.text — Text --}}
<p{{ $ui->attributes() }}>{{ $ui->text('content') ?? $ui->text('label') }}</p>
