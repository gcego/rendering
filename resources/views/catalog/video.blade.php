{{-- gcego-rendering::catalog.video — Video --}}
<video{{ $ui->attributes([
    'src' => $ui->url('src'),
    'poster' => $ui->url('poster'),
    'controls' => $ui->get('controls') !== false,
    'autoplay' => $ui->flag('autoplay'),
    'muted' => $ui->flag('muted') || $ui->flag('autoplay'),
    'loop' => $ui->flag('loop'),
    'playsinline' => true,
    'preload' => 'metadata',
    'aria-label' => $ui->text('label'),
]) }}>
    @if ($ui->url('src') !== null)
        <a{{ $ui->slot('fallback', ['href' => $ui->url('src')]) }}>Download the video</a>
    @endif
</video>
