{{-- gcego-rendering::catalog.embed — Embed: a sandboxed frame. The sandbox never grants allow-same-origin
     together with allow-scripts; publish this view to loosen it for a trusted provider. --}}
<iframe{{ $ui->attributes([
    'src' => $ui->url('src'),
    'title' => $ui->text('title') ?? $ui->text('label') ?? 'Embedded content',
    'width' => is_int($ui->get('width')) ? $ui->get('width') : null,
    'height' => is_int($ui->get('height')) ? $ui->get('height') : null,
    'loading' => 'lazy',
    'sandbox' => 'allow-scripts allow-popups allow-forms allow-presentation',
    'referrerpolicy' => 'strict-origin-when-cross-origin',
    'allowfullscreen' => true,
]) }}></iframe>
