{{-- gcego-rendering::catalog.tab — Tab: a tab panel inside Tabs, a titled section on its own --}}
@if ($ui->parentType() === 'layout.tabs')
    <div{{ $ui->attributes(['role' => 'tabpanel', 'aria-labelledby' => $ui->id().'-tab', 'tabindex' => '0', 'hidden' => ! $ui->isActiveChild()]) }}>
        @if ($ui->text('description') !== null)
            <p{{ $ui->slot('description') }}>{{ $ui->text('description') }}</p>
        @endif
        {{ $children }}
    </div>
@else
    @include('gcego-rendering::catalog.block')
@endif
