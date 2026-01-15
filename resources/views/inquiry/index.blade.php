@extends('layouts.app')

@section('content')

<h4 class="mb-3">Data Inquiry</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row mb-3">
    <div class="col-md-4">
        <input type="text"
               id="filterCustomer"
               class="form-control"
               placeholder="Filter Nama Customer">
    </div>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped" id="inquiryTable">
    <thead>
        <tr>
            <th>No Inquiry</th>
            <th>Nama Customer</th>
            <th>No HP</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Tanggal</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inquiries as $i)
        <tr>
            <td>{{ $i->no_inquiry }}</td>
            <td>{{ $i->nama_customer }}</td>
            <td>{{ $i->no_hp }}</td>
            <td>{{ $i->quantity }}</td>
            <td>Rp {{ number_format($i->harga, 0, ',', '.') }}</td>
            <td data-order="{{ $i->created_at->timestamp }}">
                {{ $i->created_at->format('d-m-Y') }}
            </td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-2">

                    {{-- DETAIL --}}
                    <button type="button"
                            class="btn btn-sm btn-info px-3"
                            data-bs-toggle="modal"
                            data-bs-target="#detailInquiry{{ $i->id }}">
                        Detail
                    </button>

                    {{-- PDF --}}
                    <a href="{{ route('inquiry.pdf', $i->id) }}"
                    target="_blank"
                    class="btn btn-sm btn-danger px-3">
                        <i class="fa fa-file-pdf"></i>
                    </a>

                    {{-- DELETE --}}
                    <form method="POST"
                        action="{{ route('inquiry.destroy', $i->id) }}"
                        onsubmit="return confirm('Hapus inquiry ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-secondary px-3">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>

                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@foreach($inquiries as $i)
<div class="modal fade"
     id="detailInquiry{{ $i->id }}"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Inquiry - {{ $i->no_inquiry }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                {{-- DATA CUSTOMER --}}
                <div class="mb-3">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="150">Nama Customer</td>
                            <td>: {{ $i->nama_customer }}</td>
                        </tr>
                        <tr>
                            <td>No HP</td>
                            <td>: {{ $i->no_hp }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $i->alamat }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: {{ $i->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>

                <hr>

                {{-- DETAIL ITEM (NOTA STYLE) --}}
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tipe</th>
                            <th width="100" class="text-center">Qty</th>
                            <th width="150" class="text-end">Harga</th>
                            <th width="150" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($i->items as $item)
                        @php
                            $subtotal = $item->quantity * $item->harga;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item->id_barang }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- TOTAL --}}
                <table class="table table-sm">
                    <tr>
                        <td class="text-end">Total</td>
                        <td width="200" class="text-end">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Ongkir</td>
                        <td class="text-end">
                            Rp {{ number_format($i->ongkir, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="fw-bold">
                        <td class="text-end">Grand Total</td>
                        <td class="text-end">
                            Rp {{ number_format($total + $i->ongkir, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {

    let table = $('#inquiryTable').DataTable({
        pageLength: 10,
        order: [[5, 'desc']], // sort by tanggal
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                next: "›",
                previous: "‹"
            }
        }
    });

    // Filter Nama Customer (kolom index ke-1)
    $('#filterCustomer').on('keyup', function () {
        table.column(1).search(this.value).draw();
    });

});
</script>
@endpush

