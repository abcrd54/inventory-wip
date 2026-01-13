@extends('layouts.app')

@section('content')

<h4 class="mb-3">Edit Status Unit (Bulk)</h4>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('unit.bulk-status.update') }}">
@csrf

<div class="row mb-3">
    <div class="col-md-4">
        <select name="status" class="form-control" required>
            <option value="">-- Pilih Status Baru --</option>
            <option value="READY">READY</option>
            <option value="REJECT">REJECT</option>
            <option value="TERJUAL">TERJUAL</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary">
            Update Status
        </button>
    </div>
</div>

<table class="table table-bordered table-striped" id="bulkTable">
    <thead>
        <tr>
            <th width="30">
                <input type="checkbox" id="checkAll">
            </th>
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
            <td class="text-center">
                <input type="checkbox"
                       name="unit_ids[]"
                       value="{{ $u->id }}">
            </td>
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

</form>

@endsection

@push('scripts')
<script>
$(function () {

    $('#bulkTable').DataTable({
        pageLength: 10
    });

    $('#checkAll').on('change', function () {
        $('input[name="unit_ids[]"]').prop('checked', this.checked);
    });

});
</script>
@endpush
