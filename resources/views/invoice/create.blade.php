@extends('layouts.app')

@section('content')
<h4>Buat Invoice</h4>

<p><b>No Inquiry:</b> {{ $inquiry->no_inquiry }}</p>

<form method="POST" action="{{ route('invoice.store') }}">
@csrf
<input type="hidden" name="inquiry_id" value="{{ $inquiry->id }}">

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label"><b>Ongkir</b></label>

        <input type="text"
               name="ongkir"
               class="form-control ongkir-input"
               value="{{ number_format($inquiry->ongkir ?? 0, 0, ',', '.') }}">
    </div>
</div>


<table class="table table-bordered">
<thead>
<tr>
    <th>Tipe</th>
    <th>Warna</th>
    <th>No Rangka</th>
    <th>No Dinamo</th>
    <th>Harga</th>
</tr>
</thead>
<tbody>

@foreach($tipeItems as $indexItem => $item)
@for($i = 0; $i < $item->quantity; $i++)
<tr>
    {{-- TIPE --}}
    <td>
        <input type="text" class="form-control" value="{{ $item->id_barang }}" readonly>
        <input type="hidden" name="items[{{ $indexItem }}][{{ $i }}][tipe]" value="{{ $item->id_barang }}">
        <input type="hidden" name="items[{{ $indexItem }}][{{ $i }}][unit_id]" class="unit-id">
    </td>

    {{-- WARNA --}}
    <td>
        <select name="items[{{ $indexItem }}][{{ $i }}][warna]"
            class="form-control warna-select" required>
            <option value="">-- Pilih Warna --</option>
            @foreach($units->where('tipe', $item->id_barang)->unique('warna') as $u)
                <option value="{{ $u->warna }}">{{ $u->warna }}</option>
            @endforeach
        </select>
    </td>

    {{-- NO RANGKA --}}
    <td>
        <select class="form-control rangka-select" required>
            <option value="">-- Pilih No Rangka --</option>
        </select>
    </td>

    {{-- NO DINAMO --}}
    <td class="dinamo"></td>

    {{-- HARGA --}}
    <td>
        <input type="text"
            name="items[{{ $indexItem }}][{{ $i }}][harga]"
            class="form-control harga-editable"
            value="{{ number_format($item->harga,0,',','.') }}"
            required>
    </td>
</tr>
@endfor
@endforeach

</tbody>
</table>

<h5 class="mt-3">
    Total Invoice:
    <span id="grand-total">Rp 0</span>
</h5>

<button class="btn btn-primary mt-3">
    Simpan Invoice
</button>

</form>
@endsection
@push('scripts')
<script>
const units = @json($units);

// ===== FORMAT RUPIAH =====
function formatRupiah(value) {
    let number_string = value.replace(/[^,\d]/g, '');
    let split = number_string.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] ? rupiah + ',' + split[1] : rupiah;
    return rupiah ? 'Rp ' + rupiah : '';
}

function parseNumber(val) {
    return parseFloat(
        val.replace(/Rp\s?/g, '').replace(/\./g, '').replace(',', '.')
    ) || 0;
}

// ===== HITUNG TOTAL =====
function hitungTotal() {
    let totalItem = 0;

    document.querySelectorAll('.harga-editable').forEach(input => {
        totalItem += parseNumber(input.value);
    });

    let ongkir = parseNumber(
        document.querySelector('.ongkir-input').value
    );

    document.getElementById('grand-total').innerText =
        formatRupiah((totalItem + ongkir).toString());
}

// ===== WARNA → RANGKA =====
document.querySelectorAll('.warna-select').forEach(select => {
    select.addEventListener('change', function () {
        const row = this.closest('tr');
        const tipe = row.querySelector('input[name*="[tipe]"]').value;
        const warna = this.value;
        const rangkaSelect = row.querySelector('.rangka-select');

        rangkaSelect.innerHTML = '<option value="">-- Pilih No Rangka --</option>';

        const selected = Array.from(document.querySelectorAll('.unit-id'))
            .map(i => i.value)
            .filter(v => v);

        units.filter(u => u.tipe == tipe && u.warna == warna)
            .forEach(u => {
                if (!selected.includes(u.id)) {
                    let opt = document.createElement('option');
                    opt.value = u.id;
                    opt.text = u.nomor_rangka;
                    opt.dataset.dinamo = u.nomor_dinamo;
                    rangkaSelect.appendChild(opt);
                }
            });

        row.querySelector('.dinamo').innerText = '';
        row.querySelector('.unit-id').value = '';
    });
});

// ===== RANGKA → DINAMO + UNIT_ID =====
document.querySelectorAll('.rangka-select').forEach(select => {
    select.addEventListener('change', function () {
        const opt = this.selectedOptions[0];
        const row = this.closest('tr');

        row.querySelector('.dinamo').innerText = opt.dataset.dinamo || '';
        row.querySelector('.unit-id').value = this.value;
    });
});

// ===== FORMAT INPUT =====
document.querySelectorAll('.harga-editable, .ongkir-input').forEach(input => {
    input.addEventListener('input', function () {
        this.value = formatRupiah(this.value);
        hitungTotal();
    });
});

// ===== SUBMIT CLEAN =====
document.querySelector('form').addEventListener('submit', function () {
    document.querySelectorAll('.harga-editable').forEach(i => {
        i.value = parseNumber(i.value);
    });

    let ongkir = document.querySelector('.ongkir-input');
    ongkir.value = parseNumber(ongkir.value);
});

hitungTotal();
</script>
@endpush
