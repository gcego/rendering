{{-- gcego-rendering::catalog.dropdown — Dropdown: a native disclosure holding a menu --}}
<details{{ $ui->attributes() }}>
    <summary{{ $ui->slot('trigger') }}>{{ $ui->text('label') ?? 'Options' }}</summary>
    <div{{ $ui->slot('menu', ['role' => 'menu']) }}>{{ $children }}</div>
</details>
