{{-- gcego-rendering::catalog.split-button — SplitButton: the main action and a menu of DropdownItems --}}
@php
    $url = $ui->flag('disabled') ? null : $ui->url('url');
@endphp
<div{{ $ui->attributes(['role' => 'group', 'aria-label' => $ui->label()]) }}>
    @if ($url !== null)
        <a{{ $ui->slot('primary', ['href' => $url]) }}>{{ $ui->label() }}</a>
    @else
        <button{{ $ui->slot('primary', ['type' => 'button', 'disabled' => $ui->flag('disabled'), 'aria-busy' => $ui->flag('loading') ? 'true' : null]) }}>{{ $ui->label() }}</button>
    @endif
    <details{{ $ui->slot('menu') }}>
        <summary{{ $ui->slot('toggle', ['aria-label' => 'More options']) }}><span aria-hidden="true">&#9662;</span></summary>
        <div{{ $ui->slot('items', ['role' => 'menu']) }}>{{ $children }}</div>
    </details>
</div>
