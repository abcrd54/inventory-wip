@extends('layouts.app')

@section('content')
<h4>Data Invoice</h4>
<div class="row mb-3">
    <div class="col-md-4">
        <input type="text"
               id="filterCustomer"
               class="form-control"
               placeholder="Filter Nama Customer">
    </div>
</div>

<table id="invoiceTable" class="table table-bordered table-striped">
<thead>
    <tr>
        <th>No Invoice</th>
        <th>No Inquiry</th>
        <th>Nama Customer</th>
        <th>Tanggal</th>
        <th width="250">Aksi</th>
    </tr>
</thead>

<tbody>
    @foreach($invoices as $i)
    <tr>
        <td>{{ $i->no_invoice }}</td>
        <td>{{ $i->inquiry->no_inquiry ?? '-' }}</td>
        <td>{{ $i->inquiry->nama_customer ?? '-' }}</td>
        <td data-order="{{ $i->created_at->timestamp }}">
            {{ $i->created_at->format('d-m-Y') }}
        </td>
        <td class="text-center">

            {{-- DETAIL --}}
            <button class="btn btn-sm btn-info mb-1"
                    data-bs-toggle="modal"
                    data-bs-target="#detailInvoice{{ $i->id }}">
                <i class="fa fa-eye"></i> Detail
            </button>

            {{-- CETAK --}}
            <a href="{{ route('invoice.pdf', $i->id) }}"
            target="_blank"
            class="btn btn-sm btn-danger mb-1">
                <i class="fa fa-file-pdf"></i> Cetak
            </a>

            {{-- DELETE --}}
            <form action="{{ route('invoice.destroy', $i->id) }}"
                method="POST"
                style="display:inline-block"
                onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-secondary">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </form>

        </td>
    </tr>
    @endforeach
</tbody>
</table>

@foreach($invoices as $i)
<div class="modal fade"
     id="detailInvoice{{ $i->id }}"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Invoice - {{ $i->no_invoice }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                {{-- DATA INQUIRY / CUSTOMER --}}
                <div class="mb-3">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="150">No Inquiry</td>
                            <td>: {{ $i->inquiry->no_inquiry ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Customer</td>
                            <td>: {{ $i->inquiry->nama_customer ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No HP</td>
                            <td>: {{ $i->inquiry->no_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $i->inquiry->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Invoice</td>
                            <td>: {{ $i->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>

                <hr>

                {{-- DETAIL UNIT (INVOICE ITEMS) --}}
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tipe</th>
                            <th>Warna</th>
                            <th>No Rangka</th>
                            <th>No Dinamo</th>
                            <th class="text-end" width="150">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalItem = 0; @endphp
                        @foreach($i->items as $item)
                        @php $totalItem += $item->harga; @endphp
                        <tr>
                            <td>{{ $item->tipe }}</td>
                            <td>{{ $item->warna }}</td>
                            <td>{{ $item->no_rangka }}</td>
                            <td>{{ $item->no_dinamo }}</td>
                            <td class="text-end">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- TOTAL --}}
                <table class="table table-sm">
                    <tr>
                        <td class="text-end">Total Item</td>
                        <td width="200" class="text-end">
                            Rp {{ number_format($totalItem, 0, ',', '.') }}
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
                            Rp {{ number_format($totalItem + $i->ongkir, 0, ',', '.') }}
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
{{-- DATATABLES --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#invoiceTable').DataTable({
        pageLength: 10,
        order: [[3, 'desc']], // sort by tanggal
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

    // Filter Nama Customer (kolom ke-2, index mulai 0)
    $('#filterCustomer').on('keyup', function () {
        table.column(2).search(this.value).draw();
    });

});
</script>
@endpush

