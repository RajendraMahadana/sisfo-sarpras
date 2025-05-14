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
        Schema::create('location_details', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade'); // Referensi ke tabel locations
            $table->string('name'); // Nama detail lokasi (misalnya: Rak 1)
            $table->text('description')->nullable(); // Deskripsi detail lokasi (opsional)
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // Referensi ke tabel users
            $table->timestamps(); // Waktu pembuatan dan pembaruan
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('location_details');
    }
};
