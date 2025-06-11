<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemReturn;
use App\Models\LoanHistory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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

        $loan = $return->loan;

        LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'returned',
            'notes'      => 'Pengembalian disetujui oleh admin.',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
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

        $loan = $return->loan;

        LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'rejected',
            'notes'      => 'Pengembalian ditolak oleh admin.',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
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
