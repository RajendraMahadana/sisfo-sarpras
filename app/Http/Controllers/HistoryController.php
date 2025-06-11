<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function userHistory()
    {
        $loans = Loan::with(['item', 'itemReturn'])
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('user.history.index', compact('loans'));
    }

    public function adminHistory()
    {
        $loans = Loan::with(['user', 'item', 'itemReturn'])
                    ->latest()
                    ->get();

        return view('loans.admin_history', compact('loans'));
    }
}
