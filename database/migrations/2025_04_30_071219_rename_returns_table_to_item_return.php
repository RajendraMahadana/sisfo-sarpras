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
        // Mengganti nama tabel 'returns' menjadi 'itemReturn'
        Schema::rename('returns', 'itemReturn');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Mengembalikan nama tabel ke 'returns' jika rollback
        Schema::rename('itemReturn', 'returns');
    }
};
