{{-- gcego-rendering::catalog.table — Table: columns from its TableColumn children, rows from Data --}}
@php
    $table = $ui->table();
@endphp
<div{{ $ui->slot('wrapper') }}>
    <table{{ $ui->attributes(['data-page-size' => $ui->integer('pageSize'), 'data-sortable' => $ui->flag('sortable') ? 'true' : null, 'data-searchable' => $ui->flag('searchable') ? 'true' : null, 'data-selectable' => $ui->flag('selectable') ? 'true' : null]) }}>
        @if ($ui->label() !== null)
            <caption{{ $ui->slot('caption') }}>{{ $ui->label() }}</caption>
        @endif
        <thead{{ $ui->slot('head') }}>
            <tr>
                @foreach ($table['columns'] as $column)
                    <th{{ $ui->slot('header', ['scope' => 'col', 'data-align' => $column['align']]) }}>{{ $column['label'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody{{ $ui->slot('body') }}>
            @forelse ($table['rows'] as $row)
                <tr{{ $ui->slot('row') }}>
                    @foreach ($row as $index => $cell)
                        <td{{ $ui->slot('cell', ['data-align' => $table['columns'][$index]['align'] ?? null]) }}>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr{{ $ui->slot('row') }}>
                    <td{{ $ui->slot('empty', ['colspan' => max(1, count($table['columns']))]) }}>No records to display.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
