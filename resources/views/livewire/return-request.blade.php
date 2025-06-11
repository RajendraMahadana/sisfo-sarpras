<div>
    <div class="flex items-center justify-between mb-5">
    <div>
      <h1 class="font-semibold text-lg leading-tight">Returns request</h1>
    </div>

    <div>
      {{ $returns->links('components.custom-pagination') }}
    </div>
  </div>
    <table class="overflow-hidden rounded-lg w-full">
        <thead>
            <tr class="text-xs">
                <th class="py-2 px-4 text-start">No</th>
                <th class="py-2 px-4 text-start">User</th>
                <th class="py-2 px-4 text-start">Barang</th>
                <th class="py-2 px-4 text-start">Kondisi</th>
                <th class="py-2 px-4 text-start">Note</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody wire:loading.class="opacity-0 transition-opacity duration-300">
            @forelse ($returns as $index => $return)
                <tr>
                    <td class="py-2 px-4 text-start">{{ $returns->firstItem() + $index  }}</td>
                    <td class="py-2 px-4 text-start">{{ $return->loan->user->name }}</td>
                    <td class="py-2 px-4 text-start">{{ $return->loan->item->name }}</td>
                    <td class="py-2 px-4 text-start">{{ $return->condition }}</td>
                    <td class="py-2 px-4 text-start">{{ $return->notes ?? '-' }}</td>
                    <td class="py-2 px-4 text-center">
                        <button wire:click="approve({{ $return->id }})" class="text-green-500 hover:text-green-700 ml-2 text-xs font-semibold">
                             <i class="ri-check-line"></i> Approve
                        </button>
                        <button wire:click="reject({{ $return->id }})" class="text-red-500 hover:text-red-700 ml-2 text-xs font-semibold">
                            <i class="ri-close-line"></i> Reject
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-4 text-center">Tidak ada request pengembalian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    window.addEventListener('notify', event => {
        const { type, message } = event.detail;
        alert(`${type.toUpperCase()}: ${message}`); // contoh sederhana
    });
</script>