{{-- gcego-rendering::catalog.pairs — DescriptionList and KeyValueList --}}
<dl{{ $ui->attributes(['aria-label' => $ui->text('label')]) }}>
    @foreach ($ui->pairs() as $term => $detail)
        <div{{ $ui->slot('pair') }}>
            <dt{{ $ui->slot('term') }}>{{ $term }}</dt>
            <dd{{ $ui->slot('detail') }}>{{ $detail }}</dd>
        </div>
    @endforeach
</dl>
