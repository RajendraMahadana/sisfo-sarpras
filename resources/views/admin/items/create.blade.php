@extends('layout.main_layout')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Tambah Barang</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Nama Barang -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Barang</label>
            <input type="text" name="name" id="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Merek Barang -->
        <div>
            <label for="brand" class="block text-sm font-medium text-gray-700">Merek Barang</label>
            <input type="text" name="brand" id="brand" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Harga Barang -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Harga Barang</label>
            <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Jumlah Barang -->
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Barang</label>
            <input type="number" name="quantity" id="quantity" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Kategori Barang -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Barang</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

         <!-- Deskripsi Barang -->
         <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Barang</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        </div>

        <!-- Kondisi Barang -->
        <div>
            <label for="condition" class="block text-sm font-medium text-gray-700">Kondisi Barang</label>
            <select name="condition" id="condition" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="new">Baru</option>
                <option value="used">Bekas</option>
                <option value="damaged">Rusak</option>
            </select>
        </div>

        <!-- Tanggal Pembelian -->
        <div>
            <label for="purchase_date" class="block text-sm font-medium text-gray-700">Tanggal Pembelian</label>
            <input type="date" name="purchase_date" id="purchase_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Nomor Seri -->
        <div>
            <label for="serial_number" class="block text-sm font-medium text-gray-700">Nomor Seri</label>
            <input type="text" name="serial_number" id="serial_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Gambar Barang -->
        <div>
            <label for="image_path" class="block text-sm font-medium text-gray-700">Gambar Barang</label>
            <input type="file" name="image_path" id="image_path" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Lokasi Utama -->
            <div class="mb-4">
        <label for="location_id" class="block text-sm font-medium text-gray-700">Lokasi</label>
        <select id="location_id" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">Pilih Lokasi</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Detail Lokasi -->
    <div>
        <label for="location_detail_id" class="block text-sm font-medium text-gray-700">Detail Lokasi (Opsional)</label>
        <select name="location_detail_id" id="location_detail_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">Pilih Detail Lokasi (Opsional)</option>
        </select>
    </div>

        <!-- Tombol Simpan -->
        <div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Simpan
            </button>
            <a href="{{ route('items.index') }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('location_id').addEventListener('change', function() {
        let locationId = this.value;
        fetch(`/admin/items/get-location-details/${locationId}`)
            .then(response => response.json())
            .then(data => {
                let detailSelect = document.getElementById('location_detail_id');
                // Kosongkan opsi yang ada dulu
                detailSelect.innerHTML = '<option value="">Pilih Detail Lokasi (Opsional)</option>';
                // Isi dengan detail lokasi baru
                data.forEach(detail => {
                    let option = document.createElement('option');
                    option.value = detail.id;
                    option.textContent = `${detail.name} (${detail.description ?? '-'})`;
                    detailSelect.appendChild(option);
                });
            })
            .catch(error => console.error(error));
    });
</script>
@endsection