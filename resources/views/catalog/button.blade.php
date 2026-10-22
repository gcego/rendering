{{-- gcego-rendering::catalog.button — Button and IconButton: a link when it has a URL, otherwise a button --}}
@php
    $label = $ui->label();
    $iconOnly = $ui->is('actions.iconButton');
    $url = $ui->flag('disabled') ? null : $ui->url('url');
@endphp
@if ($url !== null)
    <a{{ $ui->attributes(['href' => $url, 'aria-label' => $iconOnly ? $label : null, 'aria-busy' => $ui->flag('loading') ? 'true' : null, 'data-action' => $ui->text('action')]) }}>
        @if ($ui->text('icon') !== null)
            <span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>
        @endif
        @unless ($iconOnly)
            <span{{ $ui->slot('label') }}>{{ $label }}</span>
        @endunless
    </a>
@else
    <button{{ $ui->attributes([
        'type' => $ui->text('buttonType') ?? 'button',
        'disabled' => $ui->flag('disabled'),
        'aria-busy' => $ui->flag('loading') ? 'true' : null,
        'aria-label' => $iconOnly ? $label : null,
        'name' => $ui->text('buttonType') === 'submit' ? $ui->name() : null,
        'value' => $ui->text('buttonType') === 'submit' ? $ui->text('action') : null,
        'data-action' => $ui->text('action'),
    ]) }}>
        @if ($ui->text('icon') !== null)
            <span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>
        @endif
        @unless ($iconOnly)
            <span{{ $ui->slot('label') }}>{{ $label }}</span>
        @endunless
    </button>
@endif
