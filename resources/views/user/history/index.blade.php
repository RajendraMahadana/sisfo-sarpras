@extends('layout.main_layout')
@section('content') 
@include('user.component.sidebar')

<main class="main" id="main">

<h2>Histori Peminjaman Saya</h2>
@foreach($loans as $loan)
    <p>Barang: {{ $loan->item->name }}</p>
    <p>Tanggal Pinjam: {{ $loan->loan_date }}</p>
    <p>Status: {{ $loan->status }}</p>
    <p>Catatan: {{ $loan->notes }}</p>
    @if($loan->return)
        <p>Sudah Dikembalikan: {{ $loan->return->return_date }}</p>
        <p>Kondisi: {{ $loan->return->condition }}</p>
    @endif
    <hr>
@endforeach

</main>
@endsection