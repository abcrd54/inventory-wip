@extends('layouts.app')

@section('content')

<h4 class="mb-3">Tambah Unit Roda 3</h4>

<form method="POST" action="{{ route('unit.store') }}">
@csrf

<div class="row">
    <div class="col-md-4 mb-3">
        <label>Tipe</label>
        <input type="text" name="tipe" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Warna</label>
        <input type="text" name="warna" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Kategori</label>
        <input type="text" name="kategori" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>No Rangka</label>
        <input type="text" name="nomor_rangka" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>No Dinamo</label>
        <input type="text" name="nomor_dinamo" class="form-control" required>
    </div>
</div>

<button class="btn btn-primary">Simpan</button>

</form>

@endsection
