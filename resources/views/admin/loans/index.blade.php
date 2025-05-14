@extends('layout.main_layout')
@section('header-title', 'Loans')
@section('content')

@include('admin.component.sidebar')
<main class="main" id="main">
    

<div class="container">
    <h1>Daftar Semua Peminjaman</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
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
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->item->name }}</td>
                <td>{{ $loan->quantity }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ $loan->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</main>
@endsection