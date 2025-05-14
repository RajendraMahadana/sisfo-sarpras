<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('brand')->nullable(); // Merek barang
            $table->decimal('price', 10, 2)->nullable(); // Harga barang
            $table->string('storage_location')->nullable(); // Lokasi penyimpanan barang
            $table->text('description')->nullable(); // Deskripsi barang
            $table->enum('condition', ['new', 'used', 'damaged'])->default('new'); // Kondisi barang
            $table->date('purchase_date')->nullable(); // Tanggal pembelian barang
            $table->string('serial_number')->nullable(); // Nomor seri barang
        });
    }
    
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('brand'); // Menghapus kolom brand
            $table->dropColumn('price'); // Menghapus kolom price
            $table->dropColumn('storage_location'); // Menghapus kolom storage_location
            $table->dropColumn('description'); // Menghapus kolom description
            $table->dropColumn('condition'); // Menghapus kolom condition
            $table->dropColumn('purchase_date'); // Menghapus kolom purchase_date
            $table->dropColumn('serial_number'); // Menghapus kolom serial_number
        });
    }
};
