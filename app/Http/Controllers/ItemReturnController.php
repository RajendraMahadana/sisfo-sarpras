<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\ItemReturn;
use App\Models\LoanHistory;
use Illuminate\Http\Request;

class ItemReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data pengembalian barang
        $returns = ItemReturn::with('loan.item', 'loan.user')->get();

        return view('admin.returns.index', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($loan_id)
    {
        // Ambil data peminjaman berdasarkan ID
        $loan = Loan::findOrFail($loan_id);

        // Pastikan status peminjaman adalah "approved"
        if ($loan->status !== 'approved') {
            return redirect()->back()->with('error', 'Barang ini belum disetujui untuk dikembalikan.');
        }
        
        return view('user.returns.create', compact('loan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $loan_id)
    {
        // Validasi input
        $request->validate([
            'condition' => 'required|in:baik,rusak',
            'notes' => 'nullable|string',
        ]);

        // Ambil data peminjaman berdasarkan ID
        $loan = Loan::findOrFail($loan_id);

        // Pastikan status peminjaman adalah "approved"
        if ($loan->status !== 'approved') {
            return redirect()->back()->with('error', 'Barang ini belum disetujui untuk dikembalikan.');
        }

        // Simpan data pengembalian ke tabel returns
        $loan->itemReturn()->create([
            'return_date' => now(),
            'condition' => $request->condition,
            'admin_id' => auth()->user()->role === 'admin' ? auth()->id() : null,
            'notes' => $request->notes,
            'status' => 'pending',  
        ]);

        // Update status peminjaman menjadi "returned"

        return redirect()->route('show-home-user')->with('success', 'Barang berhasil dikembalikan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemReturn $itemReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemReturn $itemReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemReturn $itemReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemReturn $itemReturn)
    {
        //
    }

    public function approve($id)
    {
        $return = ItemReturn::findOrFail($id);

        if ($return->status !== 'pending') {
            return back()->with('error', 'Pengembalian ini sudah diproses.');
        }

        $return->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
        ]);

        // Update status pinjaman juga
        $return->loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        return back()->with('success', 'Pengembalian disetujui.');
    }

    public function reject($id)
    {
        $return = ItemReturn::findOrFail($id);

        if ($return->status !== 'pending') {
            return back()->with('error', 'Pengembalian ini sudah diproses.');
        }

        $return->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
        ]);

        return back()->with('success', 'Pengembalian ditolak.');
    }

public function adminCreate($loan_id)
{
    $loan = Loan::findOrFail($loan_id);

    // Admin bisa langsung buat form return kapan pun, tanpa cek status approved
    return view('admin.returns.create', compact('loan'));
}

    public function adminStore(Request $request, $loan_id)
    {
        $request->validate([
            'condition' => 'required|in:baik,rusak',
            'notes' => 'nullable|string',
        ]);

        $loan = Loan::findOrFail($loan_id);

        ItemReturn::create([
            'loan_id' => $loan->id,
            'condition' => $request->condition,
            'notes' => $request->notes,
            'status'      => 'returned',
            'return_date' => now(),
            'admin_id' => auth()->id(), // admin yang input
        ]);

        $loan->update([
            'status' => 'returned',
        ]);

        LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'returned',
            'notes'      => 'Pengembalian dilakukan oleh admin dengan kondisi.'.$request->condition,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);

        return redirect()->route('show-dashboard-admin')->with('success', 'Pengembalian berhasil dicatat oleh admin.');
    }

}
