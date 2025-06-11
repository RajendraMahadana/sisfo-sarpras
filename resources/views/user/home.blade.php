@extends('layout.main_layout')
@section('content') 
@include('user.component.sidebar')

<main class="main" id="main">

@livewire('user.home-user-management')

</main>
@endsection

{{-- <div class="min-h-screen from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header Section -->
    <div class="m-4 p-5 shadow-md rounded-xl transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-slate-800 to-indigo-800 bg-clip-text text-transparent">
                        Dashboard Peminjaman
                    </h1>
                    <p class="text-xs">Kelola peminjaman barang dengan mudah</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m-4">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
            <div class="shadow-md rounded-xl transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Kategori</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $categories->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="shadow-md rounded-xl transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Barang</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $items->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-500 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="shadow-md rounded-xl transition-all duration-300 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Peminjaman</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $loans->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items Section -->
            <div class="lg:col-span-2">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 shadow-lg">
                    <div class="p-6 border-b border-slate-200/60">
                        <h2 class="text-xl font-semibold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Daftar Barang Tersedia
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($items->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($items as $item)
                                <div class="group bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-4 border border-slate-200/60 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                            {{ $item->name }}
                                        </h3>
                                        <span class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                                            Stok: {{ $item->quantity }}
                                        </span>
                                    </div>
                                    @if($item->description)
                                        <p class="text-slate-600 text-sm mb-3 line-clamp-2">{{ $item->description }}</p>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-slate-500 bg-slate-200 px-2 py-1 rounded-full">
                                            {{ $item->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                        @if($item->quantity > 0)
                                            <a href="{{ route('user.loans.create', $item->id) }}" 
                                               class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-lg transition-all duration-200 hover:scale-105">
                                                Pinjam
                                            </a>
                                        @else
                                            <span class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-medium">
                                                Stok Habis
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-slate-500">Belum ada barang tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Categories -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 shadow-lg">
                    <div class="p-6 border-b border-slate-200/60">
                        <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Kategori
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($categories->count() > 0)
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg border border-slate-200/60">
                                    <span class="text-slate-700 font-medium">{{ $category->name }}</span>
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
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 shadow-lg">
                    <div class="p-6 border-b border-slate-200/60">
                        <h2 class="text-lg font-semibold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Peminjaman Terbaru
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($loans->count() > 0)
                            <div class="space-y-3">
                                @foreach($loans->take(5) as $loan)
                                <div class="p-3 bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg border border-slate-200/60">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-medium text-slate-800">{{ $loan->item->name }}</span>
                                        <span class="text-xs text-slate-500">
                                            {{ $loan->created_at->format('d M') }}
                                        </span>
                                    </div>
                                    @if(auth()->user()->role === 'admin')
                                        <p class="text-sm text-slate-600">{{ $loan->user->name }}</p>
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
</div> --}}