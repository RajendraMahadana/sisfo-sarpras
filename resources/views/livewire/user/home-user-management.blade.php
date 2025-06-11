<div>
    <div class="m-5 transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">
                        Dashboard Peminjaman
                    </h1>
                    <p class=" text-sm">Kelola peminjaman barang dengan mudah</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <h1 class="text-2xl font-bold">Hello {{ auth()->user()->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m-4">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="shadow-md rounded-xl transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class=" text-sm font-medium">Total Kategori</p>
                        <p class="text-3xl font-bold  mt-1">{{ $categories->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-3 rounded-xl">
                        <i class="ri-folders-line text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="shadow-md rounded-xl transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class=" text-sm font-medium">Total Barang</p>
                        <p class="text-3xl font-bold  mt-1">{{ $items->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-500 p-3 rounded-xl">
                        <i class="ri-box-3-line text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="shadow-md rounded-xl transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class=" text-sm font-medium">Total Peminjaman</p>
                        <p class="text-3xl font-bold  mt-1">{{ $loans->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-3 rounded-xl">
                        <i class="ri-folder-3-line text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Items Section -->
            <div class="lg:col-span-2">
                <div class=" rounded-xl shadow-md">
                    <div class="p-5  ">
                        <h2 class="text-xl font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Daftar Barang Tersedia
                        </h2>
                    </div>
                    <div class="p-5">
    @if($items->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($items as $item)
                <div class="group rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    
                    {{-- Gambar --}}
                    <div class="aspect-w-16 aspect-h-10 bg-gray-100">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}"
                                 alt="{{ $item->name }}"
                                 class="object-cover aspect-video transition-transform duration-300 group-hover:scale-105" />
                        @else
                            <div class="object-cover aspect-video transition-transform duration-300 group-hover:scale-105">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-500">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-4 flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-base font-semibold group-hover:text-indigo-600 transition-colors">
                                {{ $item->name }}
                            </h3>
                            <span class="text-xs px-2 py-1 rounded-full font-medium">
                                <i class="ri-box-2-line"></i> {{ $item->quantity }}
                            </span>
                        </div>

                        @if($item->description)
                            <p class="text-sm text-slate-600 line-clamp-2">{{ $item->description }}</p>
                        @endif

                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs py-1">
                                <i class="ri-stack-line"> </i>{{ $item->category->name ?? 'Tanpa Kategori' }}
                            </span>

                            @if($item->quantity > 0)
                                <a href="{{ route('user.loans.create', $item->id) }}"
                                   class="bg-purple-700 px-5 py-2 text-xs rounded-md cursor-pointer text-white hover:scale-105">
                                    Pinjam
                                </a>
                            @else
                                <span class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-medium">
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-slate-500">Belum ada barang tersedia</p>
        </div>
    @endif
</div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Categories -->
                <div class="rounded-xl shadow-md">
                    <div class="p-5  ">
                        <h2 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Kategori
                        </h2>
                    </div>
                    <div class="p-4">
                        @if($categories->count() > 0)
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                <div class="flex items-center justify-between p-3 rounded-md  ">
                                    <span class=" font-medium">{{ $category->name }}</span>
                                    <span class="bg-indigo-100 text-indigo-600 text-xs px-2 py-1 rounded-full font-medium">
                                        {{ $category->items->count() }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 text-center py-4">Belum ada kategori</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Loans -->
                <div class="rounded-xl shadow-md">
                    <div class="p-6  ">
                        <h2 class="text-lg font-semiboldflex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Peminjaman Terbaru
                        </h2>
                    </div>
                    <div class="p-5">
                        @if($loans->count() > 0)
                            <div class="space-y-3">
                                @foreach($loans->take(5) as $loan)
                                <div class="p-3 rounded-md">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-medium ">{{ $loan->item->name }}</span>
                                        <span class="text-xs text-slate-500">
                                            {{ $loan->created_at->format('d M') }}
                                        </span>
                                    </div>
                                    @if(auth()->user()->role === 'admin')
                                        <p class="text-sm ">{{ $loan->user->name }}</p>
                                    @endif
                                    <div class="mt-2">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-600',
                                                'approved' => 'bg-green-100 text-green-600',
                                                'rejected' => 'bg-red-100 text-red-600',
                                                'returned' => 'bg-blue-100 text-blue-600'
                                            ];
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $statusColors[$loan->status] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 text-center py-4">Belum ada peminjaman</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
