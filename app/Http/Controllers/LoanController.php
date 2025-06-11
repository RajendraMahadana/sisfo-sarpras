<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\ItemReturn;
use App\Models\LoanHistory;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Middleware untuk membatasi akses berdasarkan role.
     */
    public function __construct()
    {
        // Hanya user yang dapat membuat/melihat peminjaman mereka sendiri
        $this->middleware('auth');
        // Hanya admin yang dapat menyetujui/mengelola peminjaman
        $this->middleware('isAdmin')->only(['approve', 'reject', 'return']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            // Admin hanya dapat melihat peminjaman yang mereka setujui
            $loans = Loan::where('admin_id', auth()->id())
                         ->with('user', 'item')
                         ->get();
            return view('admin.loans.index', compact('loans'));
        } else {
            // User hanya dapat melihat peminjaman mereka sendiri
            $loans = Loan::where('user_id', auth()->id())
                         ->with('item')
                         ->get();
            return view('user.loans.index', compact('loans'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil daftar barang yang tersedia untuk dipinjam
        $items = Item::where('quantity', '>', 0)->get();

        return view('admin.loans.create', compact('items'));
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'loan_date' => 'required|date',
        ]);
    
        // Cek apakah barang memiliki stok yang cukup
        $item = Item::findOrFail($request->item_id);
        if ($item->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }
    
        // Simpan data peminjaman dengan status 'pending'
        Loan::create([
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'loan_date' => $request->loan_date,
            'status' => 'pending', // Status awal adalah pending
            'admin_id' => auth()->user()->role === 'admin' ? auth()->id() : null, // Admin yang membuat peminjaman
        ]);
    
        return redirect()->route('loans.index')->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    /**
     * Menyetujui permintaan peminjaman (untuk admin).
     */
    public function approve(Loan $loan)
    {
        // Pastikan status saat ini adalah 'pending'
        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman ini tidak dapat disetujui.');
        }
    
        // Perbarui status menjadi 'approved' dan catat admin yang menyetujui
        $loan->update([
            'status' => 'approved',
            'admin_id' => auth()->id(), // Simpan ID admin yang menyetujui
        ]);

        // Catat histori
        LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'approved',
            'notes'      => 'Disetujui oleh admin.',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Menolak permintaan peminjaman (untuk admin).
     */
    public function reject(Loan $loan)
    {
        // Pastikan status saat ini adalah 'pending'
        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman ini tidak dapat ditolak.');
        }

        // Perbarui status menjadi 'rejected'
        $loan->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(), // Catat admin yang menolak
        ]);

        LoanHistory::create([
            'loan_id'    => $loan->id,
            'status'     => 'rejected',
            'notes'      => $request->notes ?? 'Ditolak oleh admin.',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Mencatat pengembalian barang (untuk admin).
     */
    public function returnForm(Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return redirect()->back()->with('error', 'Barang ini belum disetujui untuk dikembalikan.');
        }
    
        return view('admin.returns.create', compact('loan'));
    }
    
    public function processReturn(Request $request, Loan $loan)
    {
        $request->validate([
            'condition' => 'required|string',
            'notes' => 'nullable|string',
        ]);
    
        // Update status loan
        $loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);
    
        // Simpan ke table returns
        ItemReturn::create([
            'loan_id' => $loan->id,
            'return_date' => now(),
            'condition' => $request->condition,
            'notes' => $request->notes,
            'admin_id' => auth()->user()->role === 'admin' ? auth()->id() : null,
        ]);
    
        return redirect()->route('loans.index')->with('success', 'Barang berhasil dikembalikan.');
    }
    
    public function show(Loan $loan) {

    }
    
}