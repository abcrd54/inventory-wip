@extends('layouts.app')

@section('content')

<h4 class="mb-3">Buat Inquiry</h4>

<form method="POST" action="{{ route('inquiry.store') }}">
@csrf

{{-- DATA CUSTOMER --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="mb-3">Data Customer</h6>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Nama Customer</label>
                <input type="text" name="nama_customer" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control">
            </div>
        </div>
    </div>
</div>

{{-- ITEM INQUIRY --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="mb-3">Detail Unit</h6>

        <table class="table table-bordered" id="itemTable">
            <thead>
                <tr>
                    <th>Tipe</th>
                    <th width="120">Quantity</th>
                    <th width="180">Harga</th>
                    <th width="40"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][tipe]" class="form-control">
                            <option value="">-- Pilih Tipe --</option>
                            @foreach($tipes as $t)
                                <option value="{{ $t->tipe }}">
                                    {{ $t->tipe }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][quantity]" class="form-control" min="1">
                    </td>
                    <td>
                        <input type="number" name="items[0][harga]" class="form-control" min="0">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-outline-primary" id="addRow">
            + Tambah Baris
        </button>
    </div>
</div>

{{-- ONGKIR --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Ongkir</label>
                <input type="number" name="ongkir" class="form-control" min="0">
            </div>
        </div>
    </div>
</div>

<button class="btn btn-primary">
    Simpan Inquiry
</button>

</form>
@endsection

@push('scripts')
<script>
let index = 1;

document.getElementById('addRow').addEventListener('click', function () {
    const tbody = document.querySelector('#itemTable tbody');

    const row = `
        <tr>
            <td>
                <select name="items[${index}][tipe]" class="form-control">
                    <option value="">-- Pilih Tipe --</option>
                    @foreach($tipes as $t)
                        <option value="{{ $t->tipe }}">{{ $t->tipe }}</option>
                    @endforeach
                </select>

            </td>
            <td>
                <input type="number" name="items[${index}][quantity]" class="form-control" min="1">
            </td>
            <td>
                <input type="number" name="items[${index}][harga]" class="form-control" min="0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger btn-remove">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        </tr>
    `;

    tbody.insertAdjacentHTML('beforeend', row);
    index++;
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-remove')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endpush
