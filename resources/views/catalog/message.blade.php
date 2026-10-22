{{-- gcego-rendering::catalog.message — Alert, Banner, Toast, EmptyState, Popover and Tooltip --}}
@php
    $status = $ui->text('status');
    $title = $ui->text('title') ?? $ui->text('label');
    $message = $ui->text('message') ?? $ui->text('description');
    $role = match (true) {
        $ui->is('feedback.alert') => in_array($status, ['danger', 'error', 'warning'], true) ? 'alert' : 'status',
        $ui->is('feedback.toast') => 'status',
        $ui->is('feedback.banner') => 'region',
        $ui->is('overlays.tooltip') => 'tooltip',
        $ui->is('overlays.popover') => 'dialog',
        default => null,
    };
@endphp
<div{{ $ui->attributes([
    'role' => $role,
    'aria-labelledby' => $title !== null && in_array($role, ['region', 'dialog'], true) ? $ui->id('title') : null,
    'aria-label' => $title === null && $role === 'region' ? 'Notice' : null,
    'data-duration' => $ui->integer('duration'),
]) }}>
    @if ($ui->text('icon') !== null)
        <span{{ $ui->slot('icon', ['data-icon' => $ui->text('icon'), 'aria-hidden' => 'true']) }}></span>
    @endif
    @if ($title !== null)
        @if ($ui->is('feedback.emptyState'))
            <h{{ $ui->level() }}{{ $ui->slot('title', ['id' => $ui->id('title')]) }}>{{ $title }}</h{{ $ui->level() }}>
        @else
            <p{{ $ui->slot('title', ['id' => $ui->id('title')]) }}><strong>{{ $title }}</strong></p>
        @endif
    @endif
    @if ($message !== null)
        <p{{ $ui->slot('message') }}>{{ $message }}</p>
    @endif
    {{ $children }}
    @if ($ui->flag('dismissible'))
        <button{{ $ui->slot('dismiss', ['type' => 'button', 'aria-label' => 'Dismiss', 'data-dismiss' => $ui->id()]) }}><span aria-hidden="true">&times;</span></button>
    @endif
</div>
