@extends('layout.main_layout')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Pengembalian Barang</h2>

    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Informasi Peminjaman</h3>
        <ul class="text-gray-600 mt-2 space-y-1">
            <li><strong>Nama Barang:</strong> {{ $loan->item->name }}</li>
            <li><strong>Jumlah:</strong> {{ $loan->quantity }}</li>
            <li><strong>Tanggal Pinjam:</strong> {{ $loan->loan_date }}</li>
        </ul>
    </div>

    <form action="{{ route('returns.store', $loan->id) }}" method="POST" class="space-y-4">
        @csrf

        {{-- Kondisi Barang --}}
        <div>
            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">
                Kondisi Barang Saat Dikembalikan
            </label>
            <select name="condition" id="condition"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
            </select>
        </div>

        {{-- Catatan Opsional --}}
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                Catatan (Opsional)
            </label>
            <textarea name="notes" id="notes" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Tambahkan catatan jika perlu"></textarea>
        </div>

        {{-- Tombol Submit --}}
        <div class="text-right">
            <button type="submit"
                class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Kembalikan Barang
            </button>
        </div>
    </form>
</div>
@endsection
