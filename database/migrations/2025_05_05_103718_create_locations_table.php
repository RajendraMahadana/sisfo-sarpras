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
    Schema::create('locations', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('name')->unique(); // Nama lokasi (misalnya: Gudang A)
        $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // Referensi ke tabel users
        $table->timestamps(); // Waktu pembuatan dan pembaruan
    });
}

public function down()
{
    Schema::dropIfExists('locations');
}
};
