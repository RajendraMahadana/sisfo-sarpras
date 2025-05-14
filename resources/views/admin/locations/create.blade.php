@extends('layout.main_layout')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Tambah Lokasi</h1>

    <form action="{{ route('locations.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Nama Lokasi -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lokasi</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <!-- Tombol Simpan -->
        <div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Simpan
            </button>
            <a href="{{ route('locations.index') }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection