@extends('layout.main_layout')

@section('content')
<div class="container">
    <h1>Riwayat Peminjaman Anda</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
            <tr>
                <td>{{ $loan->id }}</td>
                <td>{{ $loan->item->name }}</td>
                <td>{{ $loan->quantity }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ $loan->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection