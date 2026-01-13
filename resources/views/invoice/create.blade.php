@extends('layouts.app')

@section('content')
<h4>Buat Invoice</h4>

<p><b>Inquiry:</b> {{ $inquiry->no_inquiry }}</p>

<form method="POST" action="{{ route('invoice.store') }}">
@csrf

<input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">

<table class="table table-bordered">
<thead>
<tr>
    <th>Unit</th>
    <th>No Rangka</th>
    <th>No Dinamo</th>
    <th>Harga</th>
</tr>
</thead>
<tbody>

@for($i=0; $i < $inquiry->quantity; $i++)
<tr>
<td>
<select name="items[{{ $i }}][unit_id]"
        class="form-control unit-select"
        required>
<option value="">-- Pilih Unit --</option>
@foreach($units as $u)
<option value="{{ $u->id }}"
        data-rangka="{{ $u->nomor_rangka }}"
        data-dinamo="{{ $u->nomor_dinamo }}">
    {{ $u->warna }} - {{ $u->nomor_rangka }}
</option>
@endforeach
</select>
</td>

<td class="rangka"></td>
<td class="dinamo"></td>

<td>
<input type="number"
       name="items[{{ $i }}][harga]"
       value="{{ $inquiry->harga }}"
       class="form-control">
</td>
</tr>
@endfor

</tbody>
</table>

<button class="btn btn-primary">Simpan Invoice</button>
</form>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.unit-select').forEach(select => {
    select.addEventListener('change', function () {

        let selected = [];

        document.querySelectorAll('.unit-select').forEach(s => {
            if (s.value) selected.push(s.value);
        });

        document.querySelectorAll('.unit-select option').forEach(opt => {
            opt.disabled = selected.includes(opt.value);
        });

        let row = this.closest('tr');
        let opt = this.selectedOptions[0];

        row.querySelector('.rangka').innerText = opt.dataset.rangka || '';
        row.querySelector('.dinamo').innerText = opt.dataset.dinamo || '';
    });
});
</script>
@endpush
