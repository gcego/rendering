{{-- gcego-rendering::catalog.menu-item — MenuItem, with a nested list for its children --}}
<li{{ $ui->attributes() }}>
    @include('gcego-rendering::catalog.partials-link', ['root' => false])
    @if (! $children->isEmpty())
        <ul{{ $ui->slot('submenu') }}>{{ $children }}</ul>
    @endif
</li>
