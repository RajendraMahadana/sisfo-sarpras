<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanHistory extends Model
{
    use HasFactory;

     const STATUSES = [
        'pending',
        'approved',
        'rejected',
        'retruned',
    ];

     protected $fillable = [
        'loan_id',
        'status',
        'notes',
        'changed_at',
        'changed_by',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
