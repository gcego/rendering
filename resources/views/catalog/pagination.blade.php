{{-- gcego-rendering::catalog.pagination — Pagination: links carry ?page=N --}}
@php
    $pagination = $ui->pagination();
@endphp
<nav{{ $ui->attributes(['aria-label' => $ui->text('label') ?? 'Pagination', 'data-page' => $pagination['page'], 'data-pages' => $pagination['pages']]) }}>
    <ul{{ $ui->slot('list') }}>
        <li{{ $ui->slot('item') }}>
            @if ($pagination['page'] > 1)
                <a{{ $ui->slot('previous', ['href' => '?page='.($pagination['page'] - 1), 'rel' => 'prev']) }}>Previous</a>
            @else
                <span{{ $ui->slot('previous', ['aria-disabled' => 'true']) }}>Previous</span>
            @endif
        </li>
        @foreach ($pagination['links'] as $page)
            <li{{ $ui->slot('item') }}>
                <a{{ $ui->slot('page', ['href' => '?page='.$page, 'aria-current' => $page === $pagination['page'] ? 'page' : null, 'aria-label' => 'Page '.$page]) }}>{{ $page }}</a>
            </li>
        @endforeach
        <li{{ $ui->slot('item') }}>
            @if ($pagination['page'] < $pagination['pages'])
                <a{{ $ui->slot('next', ['href' => '?page='.($pagination['page'] + 1), 'rel' => 'next']) }}>Next</a>
            @else
                <span{{ $ui->slot('next', ['aria-disabled' => 'true']) }}>Next</span>
            @endif
        </li>
    </ul>
</nav>
