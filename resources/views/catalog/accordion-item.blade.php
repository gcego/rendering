{{-- gcego-rendering::catalog.accordion-item — AccordionItem: a native disclosure, open when it is the accordion's active item --}}
@php
    $description = $ui->text('description');
@endphp
<details{{ $ui->attributes(['open' => $ui->parentType() === 'layout.accordion' && $ui->isActiveChild(), 'aria-disabled' => $ui->flag('disabled') ? 'true' : null]) }}>
    <summary{{ $ui->slot('summary') }}>@if ($ui->text('icon') !== null)<span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>@endif{{ $ui->heading() ?? $ui->label() }}</summary>
    @if ($description !== null)
        <p{{ $ui->slot('description') }}>{{ $description }}</p>
    @endif
    {{ $children }}
</details>
