@extends('layout.main_layout')

@section('content')
@include('user.component.sidebar')

<main class="main" id="main">
 
<div class="flex items-center">

    <div class="rounded-lg shadow-lg m-4 hover:shadow-xl bg-white">
       
        @if ($item->image_path)
        <div class="m-2 w-[300px] aspect-[4/3]">
            <img 
                src="{{ asset('storage/' . $item->image_path) }}" 
                alt="{{ $item->name }}" 
                class="w-full h-full object-cover rounded-lg"
            >
        </div>
    @else
        <p class="m-2 text-gray-500 italic">Tidak ada gambar</p>
    @endif
        <div class="px-5 pt-2 flex flex-col">
        <h2 class="font-semibold text-xl">{{ $item->name }}</h2>
        <span>{{ $item->category->name }}</span>
        <span>{{ $item->quantity }}</span>
      </div>
    </div>
    

<div class="container w-1/2 grid">
    <h1>Form Peminjaman Barang</h1>
    <form action="{{ route('loans.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Barang</label>
            <input type="text" value="{{ $item->name }}" readonly class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <input type="number" name="quantity" id="quantity" min="1" max="{{ $item->quantity }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="loan_date" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
            <input type="date" name="loan_date" id="loan_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <button type="submit"
            class=" bg-indigo-600 w-full text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Ajukan Peminjaman
        </button>
    </form>
</div>
</div>
</main>
@endsection