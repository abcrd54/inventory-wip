<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inquiry {{ $inquiry->no_inquiry }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop img {
            height: 60px;
            margin-bottom: 5px;
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f2f2f2;
        }
        .no-border td {
            border: none;
            padding: 3px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

{{-- KOP --}}
<div class="kop">
    {{-- GANTI LOGO --}}
    <img src="{{ public_path('logo.png') }}" alt="Logo">

    <div><b>NAMA PERUSAHAAN</b></div>
    <div>Alamat Perusahaan</div>
    <div>Telp / WA: 08xxxxxxxxxx</div>
</div>

<div class="title">
    INQUIRY
</div>

{{-- INFO INQUIRY --}}
<table class="no-border">
    <tr>
        <td width="150">No Inquiry</td>
        <td>: {{ $inquiry->no_inquiry }}</td>
        <td width="150">Tanggal</td>
        <td>: {{ $inquiry->created_at->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td>Nama Customer</td>
        <td>: {{ $inquiry->nama_customer }}</td>
        <td>No HP</td>
        <td>: {{ $inquiry->no_hp }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td colspan="3">: {{ $inquiry->alamat }}</td>
    </tr>
</table>

<br>

{{-- DETAIL ITEM --}}
<table>
    <thead>
        <tr>
            <th width="40">No</th>
            <th>Tipe</th>
            <th width="80">Qty</th>
            <th width="150">Harga</th>
            <th width="150">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($inquiry->items as $index => $item)
            @php
                $subtotal = $item->quantity * $item->harga;
                $total += $subtotal;
            @endphp
            <tr>
                <td class="text-right">{{ $index + 1 }}</td>
                <td>{{ $item->id_barang }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                </td>
                <td class="text-right">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

{{-- TOTAL --}}
<table class="no-border">
    <tr>
        <td width="70%"></td>
        <td>Total</td>
        <td class="text-right" width="150">
            Rp {{ number_format($total, 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Ongkir</td>
        <td class="text-right">
            Rp {{ number_format($inquiry->ongkir, 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td><b>Grand Total</b></td>
        <td class="text-right">
            <b>Rp {{ number_format($total + $inquiry->ongkir, 0, ',', '.') }}</b>
        </td>
    </tr>
</table>

<br><br>

{{-- FOOTER --}}
<table class="no-border">
    <tr>
        <td width="60%"></td>
        <td class="text-center">
            Hormat Kami,<br><br><br>
            <b>(.....................)</b>
        </td>
    </tr>
</table>

</body>
</html>
