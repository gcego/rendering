{{-- gcego-rendering::catalog.heading — Heading: its Level, or the current heading level --}}
<h{{ $ui->level() }}{{ $ui->attributes() }}>{{ $ui->text('content') ?? $ui->text('label') }}</h{{ $ui->level() }}>
