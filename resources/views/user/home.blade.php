@extends('layout.main_layout')
@section('title', 'Home')
@section('content')

@include('user.component.sidebar')

<main class="main container" id="main">
    

<div class="container mt-20">
    <h1>Daftar Kategori</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
</form>

<div class="container">
    <h1>Daftar Barang Tersedia</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                    <a href="{{ route('user.loans.create', ['item_id' => $item->id]) }}" class="btn btn-primary btn-sm">Pinjam</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="container">
    <h1>Riwayat Peminjaman</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
            <tr>
                <td>{{ $loan->id }}</td>
                <td>{{ $loan->item->name }}</td>
                <td>{{ $loan->quantity }}</td>
                <td>{{ $loan->loan_date }}</td>
                <td>{{ ucfirst($loan->status) }}</td>
                <td>
                    @if ($loan->status === 'approved' && !$loan->return)
                        <a href="{{ route('returns.create', $loan->id) }}" class="btn btn-sm btn-primary">
                            Ajukan Pengembalian
                        </a>
                    @elseif ($loan->status === 'returned')
                        <span class="text-success">Sudah Dikembalikan</span>
                    @elseif ($loan->return && $loan->return->status === 'pending')
                        <span class="text-warning">Menunggu Persetujuan</span>
                    @elseif ($loan->return && $loan->return->status === 'rejected')
                        <span class="text-danger">Pengembalian Ditolak</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


</main>
@endsection