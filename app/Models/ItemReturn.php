<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    use HasFactory;

    const STATUSES = ['pending', 'approved', 'rejected', 'returned'];
    protected $table = 'itemReturn';

    protected $fillable = [
        'loan_id',
        'return_date' ,
        'admin_id' ,
        'notes' ,
        'condition',
        'status',
    ];

     // Relasi: Pengembalian terkait dengan satu peminjaman
     public function loan()
     {
         return $this->belongsTo(Loan::class);
     }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function admin()
     {
         return $this->belongsTo(User::class, 'admin_id');
     }
}
