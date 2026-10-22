{{-- gcego-rendering::catalog.menu — Menu: navigation of MenuItems --}}
<nav{{ $ui->attributes(['aria-label' => $ui->text('label') ?? 'Menu']) }}>
    <ul{{ $ui->slot('list') }}>{{ $children }}</ul>
</nav>
