<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        
        // Ambil user yang sedang login
        $user = auth()->user();

    // Ambil kategori berdasarkan admin_id dari user tersebut
        if (auth()->user()->role === 'admin') {
            $loans = Loan::with('user', 'item')->get();
        } else {
        // User hanya dapat melihat peminjaman mereka sendiri
            $loans = Loan::where('user_id', auth()->id())->with('item')->get();
        }
        $categories = Category::where('admin_id', $user->admin_id)->get();
        $items = Item::where('admin_id', $user->admin_id)->get();
        return view('user.home', compact('categories', 'items', 'loans'));
    }

    public function createLoan($item_id)
    {
        $user = auth()->user();
        $item = Item::findOrFail($item_id);
        $items = Item::where('admin_id', $user->admin_id)->get();

        // Pastikan stok barang tersedia
        if ($item->quantity <= 0) {
            return redirect()->route('user.items.index')->with('error', 'Stok barang tidak mencukupi.');
        }

        return view('user.loans.create', compact('item', 'items'));
    }
}
