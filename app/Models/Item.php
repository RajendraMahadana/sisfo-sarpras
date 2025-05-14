<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand',
        'price',
        'quantity',
        'location_id', 
        'location_detail_id', 
        'description',
        'condition',
        'purchase_date',
        'serial_number',
        'image_path',
        'admin_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

     // Relasi: Barang dapat memiliki banyak peminjaman
     public function loans()
     {
         return $this->hasMany(Loan::class);
     }

      // Relasi ke tabel locations
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Relasi ke tabel location_details
    public function locationDetail()
    {
        return $this->belongsTo(LocationDetail::class);
    }
}
