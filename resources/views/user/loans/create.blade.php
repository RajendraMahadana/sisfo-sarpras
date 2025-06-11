@extends('layout.main_layout')

@section('content')
@include('user.component.sidebar')

<main class="main" id="main">
    <div class="min-h-screen py-5">
        <div class="m-4">
            <!-- Header -->

            <div class="flex lg:grid-cols-2 gap-4">
                <!-- Item Details Card -->
                <div class="rounded-xl w-2/5  overflow-hidden">
                <div class="m-4">
                    <h1 class="font-semibold text-xl">Form Peminjam Barang</h1>
                    <p class="text-xs">Lengkapi form di bawah ini untuk mengajukan peminjaman</p>
                </div>
                    
                    <div class="p-5 gap-4">
                        <div>
                        <!-- Image Section -->
                        @if ($item->image_path)
                            <div class="mb-4">
                                <img 
                                    src="{{ asset('storage/' . $item->image_path) }}" 
                                    alt="{{ $item->name }}" 
                                    class="w-full h-64 object-cover rounded-xl shadow-lg"
                                >
                            </div>
                        @else
                            <div class="mb-6 h-64 bg-gray-100 rounded-xl flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-500">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                                                    
                        </div>

                        <!-- Item Information Grid -->
                        <div class="w-full space-y-4">
                            <!-- Name & Category -->
                            <div class="bg-gray-400 bg-opacity-10 rounded-lg p-3">
                                <!-- Description -->
                            @if($item->description)
                                <p class="text-sm leading-relaxed">{{ $item->description }}</p>
                            @endif
                                <h3 class="text-xl font-bold">{{ $item->name }}</h3>
                                <span class="inline-block bg-indigo-400 bg-opacity-10 text-indigo-400 text-sm px-3 py-1 rounded-md">
                                    {{ $item->category->name }}
                                </span>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-green-400 bg-opacity-10 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-green-600 font-medium">Stok Tersedia</p>
                                            <p class="text-lg font-bold text-green-400">{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($item->brand)
                                <div class="bg-blue-400 bg-opacity-10 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-blue-600 font-medium">Brand</p>
                                            <p class="text-sm font-bold text-blue-400">{{ $item->brand }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($item->condition)
                                <div class="bg-yellow-400 bg-opacity-10 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-yellow-600 font-medium">Kondisi</p>
                                            <p class="text-sm font-bold text-yellow-400">{{ $item->condition }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($item->price)
                                <div class="bg-purple-400 bg-opacity-10 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs text-purple-600 font-medium">Harga</p>
                                            <p class="text-sm font-bold text-purple-400">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Additional Information -->
                            @if($item->serial_number || $item->location_detail)
                            <div class="bg-gray-400 bg-opacity-10 rounded-lg p-4 space-y-2">
                                <h4 class="font-semibold mb-2">Informasi Tambahan</h4>
                                
                                @if($item->serial_number)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4  mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span class="text-sm ">Serial Number: <span class="font-mono font-semibold">{{ $item->serial_number }}</span></span>
                                </div>
                                @endif

                                @if($item->location_detail)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4  mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm ">Lokasi: {{ $item->location_detail->name ?? 'Tidak tersedia' }}</span>
                                </div>
                                @endif

                                @if($item->location)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm ">Lokasi: <span class="font-semibold">{{ $item->location->name ?? 'Tidak tersedia' }}</span></span>
                                </div>
                                @endif
                            </div>
                            @endif

                            
                        </div>
                    </div>
                </div>

                <!-- Loan Form Card -->
                <div class=" w-9/12 rounded-xl shadow-md overflow-hidden">
                    <div class="p-5">
                        <form action="{{ route('loans.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">

                            <!-- Item Name (readonly) -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Nama Barang
                                </label>
                                <input 
                                    type="text" 
                                    value="{{ $item->name }}" 
                                    readonly 
                                    class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"
                                >
                            </div>

                            <!-- Quantity -->
                            <div class="space-y-2">
                                <label for="quantity" class="block text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    Jumlah Pinjam
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        id="quantity" 
                                        min="1" 
                                        max="{{ $item->quantity }}" 
                                        class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"
                                        placeholder="Masukkan jumlah"
                                        required
                                    >
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="text-sm text-gray-500">/ {{ $item->quantity }}</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">Maksimal {{ $item->quantity }} unit tersedia</p>
                            </div>

                            <!-- Loan Date -->
                            <div class="space-y-2">
                                <label for="loan_date" class="block text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Tanggal Pinjam
                                </label>
                                <input 
                                    type="date" 
                                    name="loan_date" 
                                    id="loan_date" 
                                    class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"
                                    required
                                >
                            </div>

                            <!-- Notes (optional) -->
                            <div class="space-y-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Catatan (Opsional)
                                </label>
                                <textarea 
                                    name="notes" 
                                    id="notes" 
                                    rows="3"
                                    class="pl-5 pr-4 py-2 text-sm rounded-md shadow placeholder:text-sm focus:outline-none focus:ring-0 focus:border-none w-full"
                                    placeholder="Tambahkan catatan jika diperlukan..."
                                ></textarea>
                            </div>
                            <div class="flex w-full justify-end gap-2">
                                <!-- Submit Button -->
                                <button class="bg-gray-600 hover:bg-gray-700 opacity-100 text-white font-semibold px-5 py-2 rounded-lg shadow text-xs transition">

                                    <a href="{{ route('show-home-user') }}">
                                        <i class="ri-close-circle-line "> </i>
                                        Batal
                                    </a>
                                </button>
                                <button 
                                    type="submit"
                                    class="bg-purple-700 hover:bg-purple-800 text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition"
                                >
                                    <i class="ri-send-plane-line"> </i>
                                    Ajukan Peminjaman
                                </button>
                             </div>

                            <!-- Terms -->
                            <div class="rounded-lg bg-blue-700 bg-opacity-10 border border-blue-500 p-4">
                                <div class="flex items-start">      
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-blue-800 mb-1">Syarat & Ketentuan</h4>
                                        <ul class="text-xs text-blue-700 space-y-1">
                                            <li>• Barang harus dikembalikan dalam kondisi baik</li>
                                            <li>• Bertanggung jawab atas kerusakan atau kehilangan</li>
                                            <li>• Maksimal peminjaman sesuai kebijakan yang berlaku</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('loan_date').setAttribute('min', today);
    
    // Auto-focus on quantity input
    document.getElementById('quantity').focus();
});
</script>

@endsection