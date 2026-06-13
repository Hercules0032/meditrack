@props(['headers' => [], 'rows' => [], 'emptyMessage' => 'No records found.'])

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>{!! $row !!}</tr>
            @empty
                <tr><td colspan="{{ count($headers) }}" class="text-center text-muted py-4">{{ $emptyMessage }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
