{{-- gcego-rendering::catalog.breadcrumb — Breadcrumb: the active one is the current page --}}
<li{{ $ui->attributes() }}>
    @include('gcego-rendering::catalog.partials-link', ['root' => false])
</li>
