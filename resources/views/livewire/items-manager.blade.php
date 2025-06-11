<div>

@if ($confirmingDeleteId)
    <div wire:loading.class="opacity-0 transition-opacity duration-300" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000] transition-opacity duration-300">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h2>
            <p class="font-semibold text-gray-800">Apakah Anda yakin ingin menghapus kategori <span class="text-rose-400">{{ $itemToDelete->name }}?</span></p>
            <div class="flex flex-col items-center justify-center space-x-3">
                <div wire:loading.remove wire:target="confirmDelete" class=" flex justify-end w-full space-x-3">
                    <button 
                        wire:click="$set('confirmingDeleteId', null)" 
                        class="bg-gray-800 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
                        Batal
                    </button>
                    <button 
                        wire:click="confirmDelete"
                        wire:loading.attr="disabled"
                        class="bg-rose-800 hover:bg-rose-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
                        Ya, Hapus
                    </button>
                </div>
                <div wire:loading wire:target="confirmDelete" class="custom-loader"></div>
            </div>
        </div>
    </div>
    @endif

    @if ($confirmingBulkDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-[1000]">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h2>
            <p class="mb-4">Yakin ingin menghapus <strong>{{ count($itemsSelected) }}</strong> kategori terpilih? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('confirmingBulkDelete', false)" class="bg-gray-800 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">Batal</button>
                <button wire:click="deleteSelected" class="bg-rose-800 hover:bg-rose-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif

@if ($showCreateForm)
<div>
   <div>
        <h1 class="font-semibold text-xl">Create Item</h1>
        <p class="text-xs">Form create item</p>
    </div>
    <form wire:submit.prevent="save" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div class="col-span-2">
                <label for="name" class="block text-sm font-medium mb-1">Nama Barang</label>
                <input type="text" id="name" wire:model="name" required
                       class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Brand -->
            <div>
                <label for="brand" class="block text-sm font-medium mb-1">Merek</label>
                <input type="text" id="brand" wire:model="brand"
                       class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                @if ($errors->has('brand'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('brand') }}</p>
            @endif
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium mb-1">Harga</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <span class=""">Rp</span>
                    </div>
                    <input type="number" id="price" wire:model="price" min="0"
                           class="pl-10 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                </div>
               @if ($errors->has('price'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('price') }}</p>
            @endif
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium mb-1">Jumlah</label>
                <input type="number" id="quantity" wire:model="quantity" min="1" required
                       class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
               @if ($errors->has('quantity'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('quantity') }}</p>
            @endif
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium mb-1">Kategori</label>
                <select id="category_id" wire:model="category_id" required
                        class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category_id'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('category_id') }}</p>
                @endif
            </div>

            <!-- Serial Number -->
            <div>
                <label for="serial_number" class="block text-sm font-medium mb-1">Nomor Seri</label>
                <input type="text" id="serial_number" wire:model="serial_number"
                       class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                @if ($errors->has('serial_number'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('serial_number') }}</p>
            @endif
            </div>

            <!-- Purchase Date -->
            <div>
                <label for="purchase_date" class="block text-sm font-medium mb-1">Tanggal Pembelian</label>
                <input type="date" id="purchase_date"  wire:model="purchase_date"
                       class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                @if ($errors->has('purchase_date'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('purchase_date') }}</p>
                @endif
            </div>

            <!-- Condition -->
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-2">Kondisi</label>
                <div class="flex space-x-6">
                    <label class="radio-container">
                        <input class="input" type="radio" name="condition" value="new" wire:model="condition">
                        <span  class="checkmark"></span>
                        <span class="label-text">Baru</span>
                    </label>

                    <label class="radio-container">
                        <input class="input" type="radio" name="condition" value="used" wire:model="condition">
                        <span  class="checkmark"></span>
                        <span  class="label-text">Bekas</span>
                    </label>

                    <label class="radio-container">
                        <input class="input" type="radio" name="condition" value="damaged" wire:model="condition">
                        <span  class="checkmark"></span>
                        <span  class="label-text">Rusak</span>
                    </label>
                </div>
               @if ($errors->has('condition'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('condition') }}</p>
            @endif
            </div>
        </div>

        <!-- Location Selection -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-lg shadow">
            <div class="col-span-2 text-sm font-medium mb-1">Lokasi Barang</div>
            
            <div>
                <label for="location_id" class="block text-sm mb-1">Lokasi</label>
                <select id="location_id" wire:model.live="location_id" 
                        class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach ($location as $locate)
                        <option value="{{ $locate->id }}">{{ $locate->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="location_detail_id" class="block text-sm mb-1">Detail Lokasi</label>
                <select id="location_detail_id" wire:model.live="location_detail_id"
                        class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full">
                    <option value="">-- Pilih Detail Lokasi --</option>
                    @foreach ($locationdetails as $detail)
                        <option value="{{ $detail->id }}">{{ $detail->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea id="description" wire:model="description" rows="3"
                      class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"></textarea>
            @if ($errors->has('description'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('description') }}</p>
            @endif
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image_path" class="block text-sm font-medium mb-1">Gambar</label>
            <div class="mt-1 flex items-center">
                <label class="label w-full flex flex-col items-center px-4 py-6 rounded-lg shadow transition-colors">
                    <i class="ri-image-add-line text-4xl"></i>
                    <span class="mt-2 text-sm">Klik untuk upload gambar</span>
                    <input type="file" id="image_path" wire:model="image_path" class="hidden">
                </label>
            </div>
            @if ($image_path)
                <div class="mt-3">
                    <img src="{{ $image_path->temporaryUrl() }}" alt="Preview" class="h-32 w-32 object-cover rounded-md border ">
                </div>
            @endif
           @if ($errors->has('image_path'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('image_path') }}</p>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between pt-4">
            <div>
                @if (session()->has('error'))
                <div class="mb-4 font-medium flex items-center space-x-2">
                    <span class="w-2 h-2 bg-rose-400 rounded-full"></span>
                <span class="text-rose-400 shadow-teal-400">{{ session('message') }}</span>
            </div>
            @endif
            
            @if (session()->has('message'))
             <div class="mb-4 font-medium flex items-center space-x-2">
                <span class="w-2 h-2 bg-teal-400 shadow-teal-400 rounded-full"></span>
                <span class="text-teal-400 shadow-teal-400">{{ session('message') }}</span>
            </div>
            @endif
            </div>

            <div class="gap-4 flex">
            <button type="submit"
                class="bg-purple-700 hover:bg-purple-800 text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition">
                Simpan
            </button>
            <button wire:click="$set('showCreateForm', false)" type="button" class="bg-pink-600 hover:bg-pink-800 text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition">
                Batal
            </button>
            </div>

            
        </div>
    </form> 
</div>
@else
<div>
    <div class="mb-10 flex items-center gap-10">
    <div>
        <h1 class="font-semibold text-xl">Data Item</h1>
        <p class="text-xs">List data item</p>
    </div>
    </div>

    <div class="mt-4 flex justify-between w-full ">
    <div class="flex gap-4">
        <div>
        <button wire:click="$toggle('showCreateForm')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
            + Tambah Item
        </button>
        </div>

        <div>
            @if ($itemsSelected == null)
            <button 
                wire:click="confirmBulkDelete" 
                class="bg-gray-400 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
                <i class="ri-delete-bin-7-line"></i>
            </button>
            @else (count($itemsSelected) > 0)
            <button 
                wire:click="confirmBulkDelete"
                class="transition-all duration-500 ease-out opacity-100 translate-y-0 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs">
                <i class="ri-delete-bin-7-line"></i> ({{ count($itemsSelected) }})
            </button>
            @endif
        </div>
    </div>
    

     <div>
        <div class="relative w-full mb-4">
            <!-- Icon Search -->
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-base">
                <i class="ri-search-line"></i>
            </span>
            
            <!-- Input -->
            <input 
            type="text" 
            wire:model.live="keyword" 
            placeholder="Cari kategori..." 
            class="pl-10 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none"
            />
        </div>
    </div>
    </div>

    <div class="">
        <table class="overflow-hidden rounded-lg w-full shadow">
                <thead wire:loading.class="opacity-50 transition-opacity duration-300 ease-in-out"  
                       wire:target="gotoPage, nextPage, previousPage"
                       class="">
                    <tr wire:loading.class="opacity-0" 
                        wire:target="gotoPage, nextPage, previousPage" class="text-xs">
                        <th class="p-2 text-start flex gap-1 items-center">Select</th>
                        <th class="py-2 px-4 text-start">NO</th>
                        <th class="py-2 px-4 text-start">ITEM NAME</th>
                        <th class="py-2 px-4 text-start">CATEGORY</th>
                        <th class="py-2 px-4 text-start">LOCATION</th>
                        <th class="py-2 px-4 text-start">CONDITION</th>
                        <th class="py-2 px-4 text-start">QUANTITY</th>
                        <th class="py-2 px-4 text-start">DESCRIPTION</th>
                        <th class="py-2 px-4 text-center">ACTION</th>
                    </tr>
                </thead>
            <tbody wire:loading.class="opacity-0 transition-opacity duration-300"  
                   wire:target="gotoPage, nextPage, previousPage" 
                   class="text-sm">
                @foreach ($item as $index => $i)
                    <tr class=" text-sm shadow-sm">
                        <td class="py-2 px-4 text-start"><input type="checkbox" value="{{ $i->id }}" wire:model.live="itemsSelected"></td>
                        <td class="py-2 px-4 text-start text-zinc-400 font-semibold">{{ $item->firstItem() + $index }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->name }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->category->name }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->location->name ?? ''}}</td>
                        <td class="py-2 px-4 text-start">{{ $i->condition }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->quantity }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->description ?? "-" }}</td>
                        <td class="py-2 px-4 text-center space-x-2">
                            <button wire:click="edit({{ $i->id }})" class="bg-purple-700 hover:bg-purple-800 opacity-100 text-white font-semibold px-5 py-2 rounded-lg shadow text-xs transition">Edit</button>
                            <button wire:click="confirmDeletePrompt({{ $i->id }})" class="bg-red-600 hover:bg-red-700 opacity-100 text-white font-semibold px-5 py-2 rounded-lg shadow text-xs transition">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="w-full flex justify-end mt-4">
      {{ $item->links('components.custom-pagination') }}
    </div>
@endif

</div>   
</div>


 {{-- <script>
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
 --}}

