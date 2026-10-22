{{-- gcego-rendering::catalog.breadcrumbs — Breadcrumbs --}}
<nav{{ $ui->attributes(['aria-label' => $ui->text('label') ?? 'Breadcrumb']) }}>
    <ol{{ $ui->slot('list') }}>{{ $children }}</ol>
</nav>
