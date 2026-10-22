{{-- gcego-rendering::catalog.tabs — Tabs: a tab list; each Tab renders its own tab panel --}}
@php
    $heading = $ui->heading();
@endphp
<div{{ $ui->attributes() }}>
    @if ($heading !== null)
        <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $heading }}</h{{ $ui->level() }}>
    @endif
    <div{{ $ui->slot('list', ['role' => 'tablist', 'aria-labelledby' => $heading !== null ? $ui->id('title') : null, 'aria-orientation' => $ui->text('orientation')]) }}>
        @foreach ($ui->items() as $item)
            <button{{ $ui->slot('tab', [
                'type' => 'button',
                'role' => 'tab',
                'id' => $item['id'].'-tab',
                'aria-controls' => $item['id'],
                'aria-selected' => $item['active'] ? 'true' : 'false',
                'tabindex' => $item['active'] ? '0' : '-1',
                'disabled' => $item['disabled'],
                'data-icon' => $item['icon'],
            ]) }}>{{ $item['title'] }}</button>
        @endforeach
    </div>
    {{ $children }}
</div>
