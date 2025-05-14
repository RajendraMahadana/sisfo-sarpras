@if ($paginator->hasPages())
    <nav class="flex justify-center items-center">
        <ul class="inline-flex items-center space-x-2">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <li class="cursor-not-allowed">
                    <span class="block px-4 py-2 rounded-xl">
                        <i class="ri-arrow-left-s-line"></i>
                    </span>
                </li>
            @else
                <li>
                    <button wire:click="previousPage" class="px-4 py-2 rounded-xl">
                        <i class="ri-arrow-left-double-line"></i>
                    </button>
                </li>
            @endif

            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
            @endphp

            {{-- Tampilkan halaman pertama dan ... --}}
            @if ($currentPage > 3)
                <li>
                    <button wire:click="gotoPage(1)" class="px-4 py-2 text-xs font-semibold rounded-xl transition-all duration-200 ease-in-out hover:scale-105">1</button>
                </li>
                @if ($currentPage > 4)
                    <li class="px-2">...</li>
                @endif
            @endif

            {{-- Halaman tengah --}}
            @for ($page = max(1, $currentPage - 1); $page <= min($lastPage, $currentPage + 1); $page++)
                @if ($page == $currentPage)
                    <li>
                        <span class="px-4 py-2 border-b border-teal-400 text-xs text-[#2bd1c3] font-semibold">{{ $page }}</span>
                    </li>
                @else
                    <li>
                        <button wire:click="gotoPage({{ $page }})" class="px-4 py-2 text-xs font-semibold rounded-xl transition-all duration-200 ease-in-out hover:scale-105">{{ $page }}</button>
                    </li>
                @endif
            @endfor

            {{-- Tampilkan ... dan halaman terakhir --}}
            @if ($currentPage < $lastPage - 2)
                @if ($currentPage < $lastPage - 3)
                    <li class="px-2">...</li>
                @endif
                <li>
                    <button wire:click="gotoPage({{ $lastPage }})" class="px-4 py-2 text-xs font-semibold rounded-xl transition-all duration-200 ease-in-out hover:scale-105">{{ $lastPage }}</button>
                </li>
            @endif

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button wire:click="nextPage" class="px-4 py-2 rounded-xl">
                        <i class="ri-arrow-right-double-line"></i>
                    </button>
                </li>
            @else
                <li class="cursor-not-allowed">
                    <span class="block px-4 py-2 rounded-xl">
                        <i class="ri-arrow-right-s-line"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
