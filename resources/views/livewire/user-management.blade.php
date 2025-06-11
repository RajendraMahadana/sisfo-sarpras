<div>
@if ($confirmingDeleteId)
    <div wire:loading.class="opacity-0 transition-opacity duration-300" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000] transition-opacity duration-300">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h2 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h2>
            <p class="font-semibold text-gray-800">Apakah Anda yakin ingin menghapus kategori <span class="text-rose-400">{{ $userToDelete->name }}?</span></p>
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
            <p class="mb-4">Yakin ingin menghapus <strong>{{ count($usersSelected) }}</strong> kategori terpilih? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('confirmingBulkDelete', false)" class="bg-gray-800 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">Batal</button>
                <button wire:click="deleteSelected" class="bg-rose-800 hover:bg-rose-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif
@if ($showCreateForm)
    <div>
        <div class="mb-10 flex items-center gap-10">
            <div>
                <h1 class="font-semibold text-xl">Create/Edit User</h1>
                <p class="text-xs">Form create/edit user</p>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

        <form wire:submit.prevent="save" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium mb-1">Nama</label>
                    <div class="relative">
                        <i class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" id="name" wire:model.live="name" class="pl-8 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full" placeholder="Enter name">
                    </div>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <div class="relative">
                        <i class="ri-mail-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" id="email" wire:model.live="email" class="pl-8 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full" placeholder="Enter email">
                    </div>
                    @if ($errors->has('email'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="col-span-2">
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <div class="relative">
                        <i class="ri-lock-password-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="password" id="password" wire:model.live="password" class="pl-8 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full" placeholder="Enter password">
                    </div>
                    @if ($errors->has('password'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div class="col-span-2">
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmation Password</label>
                    <div class="relative">
                        <i class="ri-lock-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="password" id="password_confirmation" wire:model.live="password_confirmation" class="pl-8 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full" placeholder="Confirm password">
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="col-span-2">
                    <label for="role" class="block text-sm font-medium mb-1">Role</label>
                    <div class="relative">
                        <i class="ri-user-settings-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <select type="text" id="role" wire:model.live="role" class="pl-8 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full" placeholder="Enter role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    @if ($errors->has('role'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('role') }}</p>
                    @endif
                </div>
            </div>

            <div class="space-x-2 mt-1">
                <button wire:click="$set('showCreateForm', false)" type="button" class="bg-pink-600 hover:bg-pink-800 text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition">Cancel</button>
                <button type="submit" class="bg-purple-700 hover:bg-purple-800 px-5 py-2 text-xs rounded-lg cursor-pointer text-white">Save</button>
            </div>
        </form>
    </div>
@else

<div>
    <div class="mb-10 flex items-center gap-10">
    <div>
        <h1 class="font-semibold text-xl">Data User</h1>
        <p class="text-xs">List data user</p>
    </div>
    </div>

    <div class="mt-4 flex justify-between w-full ">
    <div class="flex gap-4">
        <div>
        <button wire:click="$toggle('showCreateForm')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
            + Tambah User
        </button>
        </div>

        <div>
            @if ($usersSelected == null)
            <button 
                wire:click="confirmBulkDelete" 
                class="bg-gray-400 hover:bg-gray-600 opacity-100 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs transition">
                <i class="ri-delete-bin-7-line"></i>
            </button>
            @else (count($usersSelected) > 0)
            <button 
                wire:click="confirmBulkDelete"
                class="transition-all duration-500 ease-out opacity-100 translate-y-0 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow text-xs">
                <i class="ri-delete-bin-7-line"></i> ({{ count($usersSelected) }})
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
                        <th class="py-2 px-4 text-start">NAME</th>
                        <th class="py-2 px-4 text-start">EMAIL</th>
                        <th class="py-2 px-4 text-start">ROLE</th>
                        <th class="py-2 px-4 text-center">ACTION</th>
                    </tr>
                </thead>
            <tbody wire:loading.class="opacity-0 transition-opacity duration-300"  
                   wire:target="gotoPage, nextPage, previousPage" 
                   class="text-sm">
                @foreach ($user as $index => $i)
                    <tr class=" text-sm shadow-sm">
                        <td class="py-2 px-4 text-start"><input type="checkbox" value="{{ $i->id }}" wire:model.live="usersSelected"></td>
                        <td class="py-2 px-4 text-start text-zinc-400 font-semibold">{{ $user->firstItem() + $index }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->name }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->email }}</td>
                        <td class="py-2 px-4 text-start">{{ $i->role ?? ''}}</td>
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
      {{ $user->links('components.custom-pagination') }}
    </div>
</div>
@endif
</div>