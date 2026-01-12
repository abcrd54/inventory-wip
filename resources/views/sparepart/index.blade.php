@extends('layouts.app')

@section('title', 'Sparepart')

@section('content')

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h5>Data Sparepart</h5>

    <button class="btn btn-primary btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah">
        <i class="ti ti-plus"></i> Tambah
    </button>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="sparepartTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Warna</th>
                    <th class="text-center align-middle" style="width:120px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spareparts as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tipe }}</td>
                    <td>{{ $item->warna }}</td>
                    <td class="text-center align-middle">
                        <div class="d-inline-flex gap-1">
                            <button
                                class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->nama }}"
                                data-tipe="{{ $item->tipe }}"
                                data-warna="{{ $item->warna }}">
                                <i class="ti ti-edit"></i>
                            </button>

                            <form method="POST"
                                action="{{ route('sparepart.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus sparepart ini?')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('sparepart.store') }}">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Sparepart</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Tipe</label>
                        <input type="text" name="tipe" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Warna</label>
                        <input type="text" name="warna" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- MODAL Edit --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" id="editNama" required>
                    </div>
                    <div class="mb-3">
                        <label>Tipe</label>
                        <input type="text" name="tipe" class="form-control" id="editTipe">
                    </div>
                    <div class="mb-3">
                        <label>Warna</label>
                        <input type="text" name="warna" class="form-control" id="editWarna">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@push('scripts')
{{-- DATATABLES --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#sparepartTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        paging: true,
        info: true,
        drawCallback: function(settings) {
            $('.dataTables_paginate').show();
            $('.dataTables_info').show();
        }
    });
});
</script>

<script>
$('.btn-edit').on('click', function () {
    const id = $(this).data('id');

    $('#editNama').val($(this).data('nama'));
    $('#editTipe').val($(this).data('tipe'));
    $('#editWarna').val($(this).data('warna'));

    $('#editForm').attr('action', `/sparepart/${id}`);

    new bootstrap.Modal(document.getElementById('editModal')).show();
});
</script>

@endpush
