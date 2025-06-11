<div>
     {{-- Navigasi --}}
    <nav class="flex gap-4 mb-4">
        <button wire:click="goTo('home')">Home</button>
        <button wire:click="goTo('tambah')">About</button>
    </nav>

    {{-- Konten halaman --}}
    <div>
        @if($page === 'home')
           @livewire('items-show-data')
        @elseif($page === 'tambah')
           @livewire('items-manager')
        @endif
    </div>
</div>
