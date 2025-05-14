<?php

namespace App\Http\Controllers;

use App\Models\ItemReturn;
use App\Models\Loan;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
{
    if (auth()->user()->role === 'admin') {
        // Admin hanya dapat melihat laporan yang mereka buat
        $reports = Report::where('admin_id', auth()->id())
                         ->orWhereNull('admin_id') // Opsional: Laporan tanpa admin_id
                         ->with('user', 'item')
                         ->get();

        return view('admin.reports.index', compact('reports'));
    } else {
        // User hanya dapat melihat laporan mereka sendiri
        $reports = Report::where('user_id', auth()->id())
                         ->with('item')
                         ->get();

        return view('user.reports.index', compact('reports'));
    }
}

    public function generateReport()
    {
        // Ambil semua data peminjaman dan pengembalian
        $loans = Loan::with('user', 'item')->get();
        $returns = ItemReturn::with('loan.item', 'loan.user')->get();
    
        // Buat laporan untuk setiap peminjaman
        foreach ($loans as $loan) {
            Report::create([
                'user_id' => $loan->user_id,
                'item_id' => $loan->item_id,
                'report_date' => now(),
                'type' => 'loan',
                'quantity' => $loan->quantity,
                'status' => $loan->status,
                'notes' => "Peminjaman oleh {$loan->user->name} untuk barang {$loan->item->name}",
                'admin_id' => auth()->id(), // Admin yang membuat laporan
            ]);
        }
    
        // Buat laporan untuk setiap pengembalian
        foreach ($returns as $return) {
            Report::create([
                'user_id' => $return->loan->user_id,
                'item_id' => $return->loan->item_id,
                'report_date' => now(),
                'type' => 'return',
                'quantity' => $return->loan->quantity,
                'status' => 'returned',
                'notes' => "Pengembalian oleh {$return->loan->user->name} untuk barang {$return->loan->item->name}",
                'admin_id' => auth()->id(), // Admin yang membuat laporan
            ]);
        }
    
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dibuat.');
    }
}
