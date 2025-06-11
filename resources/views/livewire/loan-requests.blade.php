<div>
  <div class="flex items-center justify-between mb-5">
    <div>
      <h1 class="font-semibold text-lg leading-tight">Loan request</h1>
    </div>

    <div>
      {{ $loans->links('components.custom-pagination') }}
    </div>
  </div>

  <table class="overflow-hidden rounded-lg w-full"">
    <thead>
      <tr class="text-xs">
        <th class="py-2 px-4 text-start">No</th>
        <th class="py-2 px-4 text-start">Nama Peminjam</th>
        <th class="py-2 px-4 text-start">Barang Dipinjam</th>
        <th class="py-2 px-4 text-start">Tanggal Pinjam</th>
        <th class="py-2 px-4">Status</th>
        <th class="py-2 px-4">Aksi</th>
      </tr>
    </thead>
    <tbody wire:loading.class="opacity-0 transition-opacity duration-300">
      @forelse($loans as $index => $loan)
      <tr class="text-sm">
        <td class="py-2 px-4 text-start">{{ $loans->firstItem() + $index }}</td>
        <td class="py-2 px-4 text-start">{{ $loan->user->name ?? '-' }}</td>
        <td class="py-2 px-4 text-start">{{ $loan->item->name ?? '-' }}</td>
        <td class="py-2 px-4 text-start text-xs">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d-m-Y') }}</td>
        <td class="py-2 px-4 text-center">
        @php
          $statusStyles = match($loan->status) {
            'pending' => ['text' => 'text-orange-400', 'dot' => 'bg-orange-400'],
            'approved' => ['text' => 'text-teal-400', 'dot' => 'bg-teal-400'],
            'returned' => ['text' => 'text-indigo-600', 'dot' => 'bg-indigo-600'],
            default => ['text' => 'text-rose-600', 'dot' => 'bg-rose-600']
          };
        @endphp

          <span class="inline-flex text- items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusStyles['text'] }}">
          <span class="w-2 h-2 rounded-full mr-2 {{ $statusStyles['dot'] }}"></span>
          {{ ucfirst($loan->status) }}
          </span>
        </td>
        <td class="py-2 px-4 text-center">
          @if($loan->status === 'pending')
            <button wire:click="approve({{ $loan->id }})" class="text-green-500 hover:text-green-700 ml-2 text-xs font-semibold">
              <i class="ri-check-line"></i> Approve
            </button>
          <button wire:click="reject({{ $loan->id }})" class="text-red-500 hover:text-red-700 ml-2 text-xs font-semibold">
              <i class="ri-close-line"></i> Reject
            </button>
          @elseif($loan->status === 'approved')
            <a href="{{ route('admin.returns.create', $loan->id) }}" class="text-blue-500 hover:text-blue-700 ml-2 text-xs font-semibold">
              <i class="ri-arrow-go-back-line"></i> Return
            </a>
          @else
            <span>-</span>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="py-4 text-center">Tidak ada data peminjaman.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

