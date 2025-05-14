<?php

namespace App\Livewire;

use App\Models\Loan;
use Livewire\Component;
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
    }

    public function reject($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
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
