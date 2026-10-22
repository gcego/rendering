{{-- gcego-rendering::catalog.partials-link — the link of Link, MenuItem and Breadcrumb; $root puts the component attributes on the link --}}
@php
    $url = $ui->url('url');
    $target = $ui->text('target');
    $active = $ui->get('active') === true;
    $linkAttributes = [
        'href' => $ui->flag('disabled') ? null : $url,
        'target' => $url !== null ? $target : null,
        'rel' => $target === '_blank' ? 'noopener noreferrer' : null,
        'aria-current' => $active ? 'page' : null,
        'aria-disabled' => $ui->flag('disabled') ? 'true' : null,
    ];
    $tag = $url !== null && ! $ui->flag('disabled') && ! ($active && $ui->is('navigation.breadcrumb')) ? 'a' : 'span';
@endphp
<{{ $tag }}{{ $root ? $ui->attributes($linkAttributes) : $ui->slot('link', $linkAttributes) }}>@if ($ui->text('icon') !== null)<span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>@endif{{ $ui->label() }}</{{ $tag }}>
