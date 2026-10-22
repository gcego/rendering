{{-- gcego-rendering::catalog.image — Image and Avatar (initials when an avatar has no source) --}}
@php
    $alt = $ui->text('alt') ?? $ui->text('label');
    $src = $ui->url('src');
@endphp
@if ($src !== null)
    <img{{ $ui->attributes(['src' => $src, 'alt' => $alt ?? '', 'width' => $ui->integer('width'), 'height' => $ui->integer('height'), 'loading' => 'lazy', 'decoding' => 'async']) }}>
@else
    @php
        $initials = collect(preg_split('/\s+/', trim((string) $alt)) ?: [])->filter()->take(2)->map(fn (string $word): string => mb_strtoupper(mb_substr($word, 0, 1)))->implode('');
    @endphp
    <span{{ $ui->attributes(['role' => 'img', 'aria-label' => $alt]) }}>{{ $ui->is('display.avatar') ? $initials : '' }}</span>
@endif
