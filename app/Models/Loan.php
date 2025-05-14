<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    const STATUSES = [
        'pending',
        'approved',
        'rejected',
        'retruned',
    ];

    protected $fillable = [
        'user_id',
        'quantity',
        'loan_date',
        'status',
        'item_id',
        'admin_id',
    ];

    // Relasi: Peminjaman berkaitan dengan satu barang
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi: Peminjaman dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman dapat memiliki satu pengembalian
    public function itemReturn()
    {
        return $this->hasOne(ItemReturn::class);
    }

    public static function getItemsOnLoan($adminId = null)
    {
        $query = self::where('status', 'approved')
                     ->whereNull('return_date');    

        if ($adminId) {
            $query->where('admin_id', $adminId); 
        }

        return $query->count();
    }

    public static function getItemsPendingApproval($adminId = null)
    {
        $query = self::where('status', 'pending'); // Barang yang menunggu persetujuan

        if ($adminId) {
            $query->where('admin_id', $adminId);  // Filter berdasarkan admin_id
        }

        return $query->count();
    }
}
