<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemReturn;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ReturnRequest extends Component
{
    use WithPagination;


    public function approve($id)
    {
        $return = ItemReturn::findOrFail($id);

        if ($return->status !== 'pending') {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Sudah diproses.']);
            return;
        }

        $return->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
        ]);

        $return->loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Disetujui.'
        ]);

        $this->dispatch('returnApproved');
    }

    public function reject($id)
    {
        $return = ItemReturn::findOrFail($id);

        if ($return->status !== 'pending') {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Sudah diproses.']);
            return;
        }

        $return->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
        ]);

        $return->loan->update([
            'status' => 'rejected',
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Ditolak.'
        ]);

        $this->dispatch('returnApproved');
    }

    public function render()
    {
        $adminId = Auth::id();

        $returns = ItemReturn::with('loan.item', 'loan.user', 'admin')
            ->where(function ($query) use ($adminId) {
                $query->where('admin_id', $adminId)
                      ->where('status', 'pending');
            })
            ->orWhere(function ($query) use ($adminId) {
                $query->whereNull('admin_id')
                      ->where('status', 'pending')
                      ->whereHas('loan.user', function ($q) use ($adminId) {
                          $q->where('admin_id', $adminId);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5); 

        return view('livewire.return-request', [
            'returns' => $returns
        ]);
    }
}
