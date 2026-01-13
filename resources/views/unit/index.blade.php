@extends('layouts.app')

@section('content')

<h4 class="mb-3">Data Unit Roda 3</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="tipe" class="form-control">
            <option value="">Semua Tipe</option>
            @foreach($tipeList as $t)
                <option value="{{ $t }}" {{ request('tipe')==$t?'selected':'' }}>
                    {{ $t }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="warna" class="form-control">
            <option value="">Semua Warna</option>
            @foreach($warnaList as $w)
                <option value="{{ $w }}" {{ request('warna')==$w?'selected':'' }}>
                    {{ $w }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            @foreach($statusList as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">Filter</button>
    </div>
</form>

<table class="table table-bordered table-striped" id="unitTable">
    <thead>
        <tr>
            <th>Tipe</th>
            <th>Warna</th>
            <th>Kategori</th>
            <th>No Rangka</th>
            <th>No Dinamo</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($units as $u)
        <tr>
            <td>{{ $u->tipe }}</td>
            <td>{{ $u->warna }}</td>
            <td>{{ $u->kategori }}</td>
            <td>{{ $u->nomor_rangka }}</td>
            <td>{{ $u->nomor_dinamo }}</td>
            <td>
                <span class="badge
                    @if($u->status == 'READY') bg-success
                    @elseif($u->status == 'TERJUAL') bg-info
                    @elseif($u->status == 'REJECT') bg-danger
                    @else bg-secondary
                    @endif
                ">
                    {{ $u->status }}
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
    $('#unitTable').DataTable({
        pageLength: 10
    });
});
</script>
@endpush
