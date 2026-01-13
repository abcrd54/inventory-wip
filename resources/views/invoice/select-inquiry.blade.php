@extends('layouts.app')

@section('content')
<h4 class="mb-3">Pilih Inquiry</h4>

<div class="card">
    <div class="card-body">

        {{-- FILTER --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text"
                       id="filterNoInquiry"
                       class="form-control"
                       placeholder="Cari No Inquiry">
            </div>

            <div class="col-md-4">
                <input type="text"
                       id="filterCustomer"
                       class="form-control"
                       placeholder="Cari Nama Customer">
            </div>
        </div>

        {{-- TABLE --}}
        <table class="table table-bordered table-striped" id="inquiryTable">
            <thead>
                <tr>
                    <th>No Inquiry</th>
                    <th>Customer</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $i)
                <tr>
                    <td>{{ $i->no_inquiry }}</td>
                    <td>{{ $i->nama_customer }}</td>
                    <td>{{ $i->quantity }}</td>
                    <td>
                        <b>Rp {{ number_format($i->total, 0, ',', '.') }}</b>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('invoice.create', $i->id) }}"
                           class="btn btn-primary btn-sm px-3">
                           Buat Invoice
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    const table = $('#inquiryTable').DataTable({
        pageLength: 10,
        ordering: true,
        lengthChange: false
    });

    // Filter No Inquiry
    $('#filterNoInquiry').on('keyup', function () {
        table.column(0).search(this.value).draw();
    });

    // Filter Customer
    $('#filterCustomer').on('keyup', function () {
        table.column(1).search(this.value).draw();
    });

});
</script>
@endpush
