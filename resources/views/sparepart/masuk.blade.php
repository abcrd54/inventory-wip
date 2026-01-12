@extends('layouts.app')

@section('content')

<h4 class="mb-3">Data Masuk Sparepart</h4>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('sparepart.masuk.store') }}">
@csrf

<table class="table table-bordered" id="formTable">
    <thead>
        <tr>
            <th>Sparepart</th>
            <th width="120">Jumlah</th>
            <th>Order By</th>
            <th>Keterangan</th>
            <th width="40"></th>
        </tr>
    </thead>

    <tbody>
        @for($i = 0; $i < 5; $i++)
        <tr>
            <td>
                <select name="items[{{ $i }}][id_barang]" class="form-control">
                    <option value="">-- Pilih Sparepart --</option>
                    @foreach($spareparts as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="number"
                       name="items[{{ $i }}][jumlah]"
                       class="form-control"
                       min="1">
            </td>

            <td>
                <input type="text"
                       name="items[{{ $i }}][order_by]"
                       class="form-control">
            </td>

            <td>
                <input type="text"
                       name="items[{{ $i }}][keterangan]"
                       class="form-control">
            </td>

            <td class="text-center">
                <button type="button"
                        class="btn btn-sm btn-danger btn-remove">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        </tr>
        @endfor
    </tbody>
</table>

<button type="button"
        class="btn btn-outline-primary mb-3"
        id="addRow">
    + Tambah Baris
</button>

<br>

<button type="submit" class="btn btn-primary">
    Simpan Data
</button>

</form>

@endsection

@push('scripts')
<script>
let index = 5;

document.getElementById('addRow').addEventListener('click', function () {

    let tbody = document.querySelector('#formTable tbody');

    let row = `
    <tr>
        <td>
            <select name="items[${index}][id_barang]" class="form-control">
                <option value="">-- Pilih Sparepart --</option>
                @foreach($spareparts as $s)
                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="number"
                   name="items[${index}][jumlah]"
                   class="form-control"
                   min="1">
        </td>

        <td>
            <input type="text"
                   name="items[${index}][order_by]"
                   class="form-control">
        </td>

        <td>
            <input type="text"
                   name="items[${index}][keterangan]"
                   class="form-control">
        </td>

        <td class="text-center">
            <button type="button"
                    class="btn btn-sm btn-danger btn-remove">
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
