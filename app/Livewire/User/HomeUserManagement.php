<?php

namespace App\Livewire\User;

use App\Models\Item;
use App\Models\Loan;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeUserManagement extends Component
{
    public function render()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $loans = Loan::with('user', 'item')->get();
        } else {
            $loans = Loan::where('user_id', $user->id)->with('item')->get();
        }

        $categories = Category::where('admin_id', $user->admin_id)->get();
        $items = Item::where('admin_id', $user->admin_id)->get();

        return view('livewire.user.home-user-management', [
            'categories' => $categories,
            'items' => $items,
            'loans' => $loans,
        ]);
    }
}
