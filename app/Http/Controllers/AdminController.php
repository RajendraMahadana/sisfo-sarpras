<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use App\Models\Report;
use App\Models\Category;
use App\Models\ItemReturn;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat admin baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set role admin
        ]);

        return redirect()->route('show-login')->with('success', 'Akun admin berhasil dibuat. Silakan login.');
    }

    public function showDashboard()
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
    
        
        $reports = Report::where('admin_id', $adminId)
                         ->orWhere(function ($query) use ($adminId) {
                            $query->whereNull('admin_id')
                                  ->whereHas('user', fn($q) => $q->where('admin_id', $adminId));
                         })
                         ->with('user', 'item')
                         ->get();

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
                            ->get();
    
        
        $userCount = User::where('admin_id', $adminId)
                         ->where('role', '!=', 'admin')
                         ->count();

        $loanCount = Loan::where('status', 'returned')
                         ->whereHas('user', fn($q) => $q->where('admin_id', $adminId))
                         ->count();

        $itemsPendingApproval = Loan::where('status', 'pending')
                         ->whereHas('user', fn($q) => $q->where('admin_id', $adminId))
                         ->count();

        $itemsOnLoan = Loan::where('status', 'approved')
                         ->whereHas('user', fn($q) => $q->where('admin_id', $adminId))
                         ->count();
    
        $itemCount = Item::where('admin_id', $adminId)->count();
        $categoryCount = Category::where('admin_id', $adminId)->count();

        // Daily (7 hari terakhir)
        $dailyData = Loan::selectRaw('DATE(loan_date) as date, SUM(quantity) as total')
                         ->where('admin_id', $adminId)
                         ->whereBetween('loan_date', [now()->subDays(6), now()])
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get();

        // Weekly (4 minggu terakhir)
        $weeklyData = Loan::selectRaw('YEARWEEK(loan_date, 1) as week, SUM(quantity) as total')
                         ->where('admin_id', $adminId)
                         ->whereBetween('loan_date', [now()->subWeeks(3), now()])
                         ->groupBy('week')
                         ->orderBy('week')
                         ->get();

        // Monthly (1 tahun terakhir)
        $monthlyData = Loan::selectRaw('MONTH(loan_date) as month, SUM(quantity) as total')
                         ->where('admin_id', $adminId)
                         ->whereYear('loan_date', now()->year)
                         ->groupBy('month')
                         ->orderBy('month')
                         ->get();

        // Yearly (5 tahun terakhir)
        $yearlyData = Loan::selectRaw('YEAR(loan_date) as year, SUM(quantity) as total')
                         ->where('admin_id', $adminId)
                         ->whereBetween('loan_date', [now()->subYears(4), now()])
                         ->groupBy('year')
                         ->orderBy('year')
                         ->get();
    
        
        $totalQuantity = Loan::where('admin_id', $adminId)->sum('quantity');
        $items = Item::where('admin_id', $adminId)->get();
        $categories = Category::where('admin_id', $adminId)->get();
        $users = User::where('admin_id', $adminId)->get();
        
        
    
        return view('admin.dashboard', compact(
            'categories', 
            'items',
            'users', 
            'loans', 
            'returns', 
            'reports',
            'userCount', 
            'itemCount', 
            'categoryCount',
            'loanCount',
            'totalQuantity',
            'dailyData',
            'monthlyData',
            'yearlyData',
            'weeklyData',
            'itemsOnLoan', 
            'itemsPendingApproval'
        ));
    }
    
}
