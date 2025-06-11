<?php

namespace App\Livewire;

use App\Models\Loan;
use Livewire\Component;
use App\Models\LoanHistory;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class LoanRequests extends Component
{
   use WithPagination;


    #[On('returnApproved')] // tangkap event return disetujui
    public function refreshPage()
    {
       
    }
    public function approve($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
        ]);

         LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'approved',
            'notes'      => 'Peminjaman disetujui oleh admin.',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);
    }

    public function reject($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
        ]);

        LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'rejected',
            'notes'      => 'Peminjaman ditolak oleh admin.',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);
    }

    public function render()
    {
        $adminId = auth()->id();

        $loans = Loan::where('admin_id', $adminId)
            ->orWhere(function ($query) use ($adminId) {
                $query->whereNull('admin_id')
                      ->where('status', 'pending')
                      ->whereHas('user', fn($q) => $q->where('admin_id', $adminId));
            })
            ->with('user', 'item')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.loan-requests', compact('loans'));
    }
}
