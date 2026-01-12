@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header mb-4">
    <h5>Dashboard</h5>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Sparepart</h6>
                <h3>120</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Unit Roda 3</h6>
                <h3>35</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6>Stok Kritis</h6>
                <h3 class="text-danger">5</h3>
            </div>
        </div>
    </div>
</div>
@endsection
