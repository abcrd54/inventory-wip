@extends('layouts.app')

@section('content')

<h4 class="mb-3">Riwayat Aktivitas Sparepart</h4>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="jenis" class="form-control">
            <option value="">Semua</option>
            <option value="masuk" {{ request('jenis')=='masuk'?'selected':'' }}>Masuk</option>
            <option value="keluar" {{ request('jenis')=='keluar'?'selected':'' }}>Keluar</option>
        </select>
    </div>

    <div class="col-md-3">
        <input type="date"
               name="tanggal"
               value="{{ request('tanggal') }}"
               class="form-control">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">Filter</button>
    </div>
</form>

<table class="table table-bordered table-striped" id="riwayatTable">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Jenis</th>
            <th>Sparepart</th>
            <th>Jumlah</th>
            <th>Order By</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->created_at }}</td>
            <td>
                @if($row->tipe == 'masuk')
                    <span class="badge bg-success">Masuk</span>
                @else
                    <span class="badge bg-danger">Keluar</span>
                @endif
            </td>
            <td>{{ $row->sparepart->nama ?? '-' }}</td>
            <td>{{ $row->jumlah }}</td>
            <td>{{ $row->order_by }}</td>
            <td>{{ $row->keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#riwayatTable').DataTable({
        order: [[0, 'desc']],
        pageLength: 10
    });
});
</script>
@endpush
