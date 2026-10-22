{{-- gcego-rendering::catalog.code — CodeBlock: escaped source, highlighted client-side if at all --}}
<pre{{ $ui->attributes(['aria-label' => $ui->text('label')]) }}><code{{ $ui->slot('code', ['data-language' => $ui->text('language')]) }}>{{ $ui->text('content') }}</code></pre>
