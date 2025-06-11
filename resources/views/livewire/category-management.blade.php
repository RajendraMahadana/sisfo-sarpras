

<div class="m-4 p-5 shadow-md rounded-xl transition-all duration-300">
    <style>
    .custom-loader {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: 
    radial-gradient(farthest-side,#766DF4 94%,#0000) top/4px 4px no-repeat,
    conic-gradient(#0000 30%,#766DF4);
  -webkit-mask: radial-gradient(farthest-side,#0000 calc(100% - 4px),#000 0);
  animation:s3 1s infinite linear;
}

@keyframes s3{ 
  100%{transform: rotate(1turn)}
}

@keyframes fadeSlideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-slide-in {
  animation: fadeSlideIn 0.5s ease-out forwards;
}
</style>
    <div class="mb-10 flex items-center gap-10">
        <div>
            <h1 class="font-semibold text-xl">Data Category</h1>
            <p class="text-xs">List Data Category</p>
        </div>

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
    </div>

    
    @if ($confirmingDeleteId)
    <div wire:loading.class="opacity-0 transition-opacity duration-300" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000] transition-opacity duration-300">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h2>
            <p class="font-semibold text-gray-800">Apakah Anda yakin ingin menghapus kategori <span class="text-rose-400">{{ $categoryToDelete->name }}?</span></p>
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
            <p class="mb-4">Yakin ingin menghapus <strong>{{ count($categoriesSelected) }}</strong> kategori terpilih? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('confirmingBulkDelete', false)" class="bg-gray-800 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">Batal</button>
                <button wire:click="deleteSelected" class="bg-rose-800 hover:bg-rose-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif

    @if ($showCreateForm)
    <div  wire:loading.class="opacity-50 transition-opacity duration-500 ease-in-out"  
         class="shadow-md rounded-xl p-5 transition-all duration-500 ease-in-out opacity-100 scale-100">
        <h2 class="text-md font-semibold mb-4">Form Tambah Kategori</h2>

        <div class="mb-4">
            <input type="text" id="newName" wire:model="newName"
                class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"
                placeholder="Input Category Name">
            @error('newName') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <input type="text" id="newDescription" wire:model="newDescription"
                class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"
                placeholder="Description (Opsional)">
            @if ($errors->has('newDescription'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->first('newDescription') }}</p>
            @endif
        </div>

        <div class="flex space-x-2">
            <button wire:click="create"
                class="bg-purple-700 hover:bg-purple-800 text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition">
                Simpan
            </button>
            <button wire:click="$set('showCreateForm', false)"
                class="bg-pink-600 hover:bg-pink-800 text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition">
                Batal
            </button>
        </div>
    </div>
    @endif

    @if ($editId)
    <div class=" shadow-md rounded-xl p-5">
        <h2 class="text-md font-semibold mb-4">Edit Category</h2>
        <input type="text" wire:model="name" class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full mb-4" placeholder="Category Name">
        <input type="text" wire:model="description" class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full mb-4" placeholder="Description">

        <div class="space-x-2 mt-1">
            <button wire:click="update" class="bg-purple-700 hover:bg-purple-800 px-5 py-2 text-xs rounded-lg cursor-pointer text-white">Save</button>
            <button wire:click="resetEdit" class="bg-pink-600 hover:bg-pink-700 text-white text-xs font-semibold px-5 py-2 rounded-lg">Cancel</button>
        </div>
    </div>
    @endif

    <div class="mt-4 flex justify-between w-full ">
        <div class="flex gap-4">
            <div>
                <button wire:click="$toggle('showCreateForm')"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
                + Tambah Kategori
            </button>
            </div>

            <div>
            @if ($categoriesSelected == null)
                <button 
                    wire:click="confirmBulkDelete" 
                    class="bg-gray-400 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
                    <i class="ri-delete-bin-7-line"></i>
                </button>
            @else (count($categoriesSelected) > 0)
                 <button 
                    wire:click="confirmBulkDelete"
                    class="transition-all duration-500 ease-out opacity-100 translate-y-0
                        bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs">
                    <i class="ri-delete-bin-7-line"></i> ({{ count($categoriesSelected) }})
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
                        <th class="py-2 px-4 text-start">CATEGORY NAME</th>
                        <th class="py-2 px-4 text-start">TOTAL ITEM</th>
                        <th class="py-2 px-4 text-start">DESCRIPTION</th>
                        <th class="py-2 px-4 text-center">ACTION</th>
                    </tr>
                </thead>
            <tbody wire:loading.class="opacity-0 transition-opacity duration-300"  
                   wire:target="gotoPage, nextPage, previousPage" 
                   class="text-sm">
                @foreach ($categories as $index => $category)
                    <tr class=" text-sm shadow-sm">
                        <td class="py-2 px-4 text-start"><input type="checkbox" value="{{ $category->id }}" wire:model.live="categoriesSelected"></td>
                        <td class="py-2 px-4 text-start text-zinc-400 font-semibold">{{ $categories->firstItem() +  $index }}</td>
                        <td class="py-2 px-4 text-start">{{ $category->name }}</td>
                        <td class="py-2 px-4 text-start">{{ $category->items->sum('quantity') }}</td>
                        <td class="py-2 px-4 text-start">{{ $category->description ?? "-" }}</td>
                        <td class="py-2 px-4 text-center space-x-2">
                            <button wire:click="edit({{ $category->id }})" class="bg-purple-700 hover:bg-purple-800 opacity-100 text-white font-semibold px-5 py-2 rounded-lg shadow text-xs transition">Edit</button>
                            <button wire:click="confirmDeletePrompt({{ $category->id }})" class="bg-red-600 hover:bg-red-700 opacity-100 text-white font-semibold px-5 py-2 rounded-lg shadow text-xs transition">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="w-full flex justify-end mt-4">
      {{ $categories->links('components.custom-pagination') }}
    </div>

</div>
