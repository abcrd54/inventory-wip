@extends('layouts.app')

@section('content')

<h4 class="mb-3">Tunggu Pengiriman</h4>

<table class="table table-bordered table-striped" id="pengirimanTable">
    <thead class="table-light">
        <tr>
            <th>No Invoice</th>
            <th>No Inquiry</th>
            <th>Tipe</th>
            <th>Jumlah Unit</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $inv)
        <tr>
            <td>{{ $inv->no_invoice }}</td>
            <td>{{ $inv->inquiry->no_inquiry }}</td>
            <td>{{ $inv->inquiry->tipe }}</td>
            <td>
                <span class="badge bg-primary">
                    {{ $inv->items->count() }}
                </span>
            </td>
            <td>
                <span class="badge bg-warning">
                    Tunggu Pengiriman
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('scripts')
<script>
$(function () {
    $('#pengirimanTable').DataTable();
});
</script>
@endpush
