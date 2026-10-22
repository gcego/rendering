{{-- gcego-rendering::catalog.audio — Audio --}}
<audio{{ $ui->attributes([
    'src' => $ui->url('src'),
    'controls' => $ui->get('controls') !== false,
    'autoplay' => $ui->flag('autoplay'),
    'muted' => $ui->flag('muted'),
    'loop' => $ui->flag('loop'),
    'preload' => 'metadata',
    'aria-label' => $ui->text('label'),
]) }}>
    @if ($ui->url('src') !== null)
        <a{{ $ui->slot('fallback', ['href' => $ui->url('src')]) }}>Download the audio</a>
    @endif
</audio>
