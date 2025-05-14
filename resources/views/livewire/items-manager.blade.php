<div>
    <h2 class="text-2xl font-bold mb-4 text-center">Tambah/Edit Barang</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Barang</label>
            <input type="text" id="name" wire:model="name" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Brand -->
        <div>
            <label for="brand" class="block text-sm font-medium text-gray-700">Merek</label>
            <input type="text" id="brand" wire:model="brand"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('brand') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" id="price" wire:model="price" min="0"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Quantity -->
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <input type="number" id="quantity" wire:model="quantity" min="1" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

         <!-- Lokasi -->
    <div class="mb-4">
        <label for="location_id" class="block text-sm font-medium text-gray-700">Lokasi</label>
        <select wire:model="location_id" id="location_id" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">Pilih Lokasi</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
            @endforeach
        </select>
        @error('location_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Detail Lokasi -->
    <div>
        <label for="location_detail_id" class="block text-sm font-medium text-gray-700">Detail Lokasi (Opsional)</label>
        <select wire:model="location_detail_id" name="location_detail_id" id="location_detail_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">Pilih Detail Lokasi (Opsional)</option>
        </select>
        @error('location_detail_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>


        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="description" wire:model="description" rows="3"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image_path" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" id="image_path" wire:model="image_path"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @if ($image_path)
                <img src="{{ $image_path->temporaryUrl() }}" alt="Preview" class="mt-2 w-32 h-32 object-cover rounded-md">
            @endif
            @error('image_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Condition -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Kondisi</label>
            <div class="mt-1 space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" value="new" wire:model="condition" class="form-radio">
                    <span class="ml-2">Baru</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" value="used" wire:model="condition" class="form-radio">
                    <span class="ml-2">Bekas</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" value="damaged" wire:model="condition" class="form-radio">
                    <span class="ml-2">Rusak</span>
                </label>
            </div>
            @error('condition') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Purchase Date -->
        <div>
            <label for="purchase_date" class="block text-sm font-medium text-gray-700">Tanggal Pembelian</label>
            <input type="date" id="purchase_date" wire:model="purchase_date"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('purchase_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Serial Number -->
        <div>
            <label for="serial_number" class="block text-sm font-medium text-gray-700">Nomor Seri</label>
            <input type="text" id="serial_number" wire:model="serial_number"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('serial_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Category -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="category_id" wire:model="category_id" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Simpan
            </button>
        </div>
    </form>
</div>
 <script>
document.getElementById('location_id').addEventListener('change', function () {
        let locationId = this.value; // Ambil nilai location_id yang dipilih
        let detailSelect = document.getElementById('location_detail_id');

        // Jika tidak ada lokasi yang dipilih, kosongkan dropdown detail lokasi
        if (!locationId) {
            detailSelect.innerHTML = '<option value="">Pilih Detail Lokasi (Opsional)</option>';
            return;
        }

        // Fetch data detail lokasi dari API
        fetch(`/admin/items/get-location-details/${locationId}`)
            .then(response => response.json()) // Parse response sebagai JSON
            .then(data => {
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
            .catch(error => console.error('Error fetching location details:', error));
    });

</script>


