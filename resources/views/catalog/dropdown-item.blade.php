{{-- gcego-rendering::catalog.dropdown-item — DropdownItem: a menu item link or button --}}
@php
    $url = $ui->flag('disabled') ? null : $ui->url('url');
@endphp
@if ($url !== null)
    <a{{ $ui->attributes(['role' => 'menuitem', 'href' => $url]) }}>
@else
    <button{{ $ui->attributes(['role' => 'menuitem', 'type' => 'button', 'disabled' => $ui->flag('disabled'), 'aria-busy' => $ui->flag('loading') ? 'true' : null]) }}>
@endif
    @if ($ui->text('icon') !== null)
        <span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>
    @endif
    <span{{ $ui->slot('label') }}>{{ $ui->label() }}</span>
@if ($url !== null)
    </a>
@else
    </button>
@endif
@if (! $children->isEmpty())
    <div{{ $ui->slot('group', ['role' => 'group']) }}>{{ $children }}</div>
@endif
