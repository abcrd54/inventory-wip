@extends('layouts.app')

@section('content')
<h4>Data Invoice</h4>

<table class="table table-bordered">
<thead>
<tr>
    <th>No Invoice</th>
    <th>No Inquiry</th>
    <th>Tanggal</th>
</tr>
</thead>
<tbody>
@foreach($invoices as $i)
<tr>
    <td>{{ $i->no_invoice }}</td>
    <td>{{ $i->inquiry->no_inquiry }}</td>
    <td>{{ $i->created_at->format('d-m-Y') }}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
