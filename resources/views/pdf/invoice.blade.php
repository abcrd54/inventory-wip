<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice</title>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #000;
    }
    .header {
        width: 100%;
        border-bottom: 2px solid #000;
        margin-bottom: 10px;
    }
    .header td {
        vertical-align: middle;
    }
    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin: 15px 0;
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
        text-align: center;
    }
    .no-border td {
        border: none;
        padding: 4px;
    }
    .right {
        text-align: right;
    }
</style>
</head>
<body>

{{-- HEADER --}}
<table class="header no-border">
<tr>
    <td width="20%">
        <img src="{{ $company['logo'] }}" width="80">
    </td>
    <td width="80%">
        <b>{{ $company['name'] }}</b><br>
        {{ $company['address'] }}<br>
        Telp: {{ $company['phone'] }}
    </td>
</tr>
</table>

<div class="title">INVOICE</div>

{{-- INFO INVOICE --}}
<table class="no-border">
<tr>
    <td width="50%">
        <b>No Invoice</b> : {{ $invoice->no_invoice }}<br>
        <b>Tanggal</b> : {{ $invoice->created_at->format('d-m-Y') }}<br>
        <b>No Inquiry</b> : {{ $invoice->inquiry->no_inquiry }}
    </td>
</tr>
</table>

<br>

{{-- CUSTOMER --}}
<table class="no-border">
<tr>
    <td>
        <b>Kepada Yth:</b><br>
        {{ $invoice->inquiry->nama_customer ?? '-' }}<br>
        {{ $invoice->inquiry->alamat ?? '-' }}
    </td>
</tr>
</table>

<br>

{{-- ITEM --}}
<table>
<thead>
<tr>
    <th width="5%">No</th>
    <th>Tipe</th>
    <th>Warna</th>
    <th>No Rangka</th>
    <th class="right">Harga</th>
</tr>
</thead>
<tbody>
@foreach($invoice->items as $i => $item)
<tr>
    <td align="center">{{ $i + 1 }}</td>
    <td>{{ $item->tipe }}</td>
    <td>{{ $item->warna }}</td>
    <td>{{ $item->no_rangka }}</td>
    <td class="right">Rp {{ number_format($item->harga,2,',','.') }}</td>
</tr>
@endforeach
</tbody>
</table>

<br>

{{-- TOTAL --}}
<table>
<tr>
    <td class="right"><b>Subtotal</b></td>
    <td width="25%" class="right">
        Rp {{ number_format($invoice->items->sum('harga'),2,',','.') }}
    </td>
</tr>
<tr>
    <td class="right"><b>Ongkir</b></td>
    <td class="right">
        Rp {{ number_format($invoice->ongkir,2,',','.') }}
    </td>
</tr>
<tr>
    <td class="right"><b>TOTAL</b></td>
    <td class="right">
        <b>Rp {{ number_format($invoice->total,2,',','.') }}</b>
    </td>
</tr>
</table>

<br><br>

{{-- CATATAN --}}
<table class="no-border">
<tr>
<td>
<b>Catatan:</b><br>
- Harga sudah termasuk PPN (jika ada)<br>
- Barang dikirim sesuai ketentuan<br>
- Pembayaran sesuai kesepakatan
</td>
</tr>
</table>

<br><br>

{{-- TTD --}}
<table class="no-border">
<tr>
<td width="60%"></td>
<td align="center">
    Hormat Kami,<br><br><br>
    <b>{{ $company['name'] }}</b>
</td>
</tr>
</table>

</body>
</html>
