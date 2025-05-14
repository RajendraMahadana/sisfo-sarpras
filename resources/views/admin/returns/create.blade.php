@extends('layout.main_layout')

@section('content')
 <div class="max-w-xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Form Pengembalian oleh Admin</h1>
        <form action="{{ route('admin.returns.store', $loan->id) }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Nama Barang:</label>
                <p class="text-gray-700">{{ $loan->item->name }}</p>
            </div>

            <div>
                <label for="condition" class="block font-semibold">Kondisi Barang:</label>
                <select name="condition" id="condition" class="w-full border rounded p-2">
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                </select>
            </div>

            <div>
                <label for="notes" class="block font-semibold">Catatan (Opsional):</label>
                <textarea name="notes" id="notes" rows="3" class="w-full border rounded p-2"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Pengembalian
            </button>
        </form>
    </div>
@endsection
