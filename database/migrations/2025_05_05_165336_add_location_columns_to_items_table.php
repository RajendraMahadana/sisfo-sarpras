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
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null'); // Referensi ke tabel locations
            $table->foreignId('location_detail_id')->nullable()->constrained('location_details')->onDelete('set null'); // Referensi ke tabel location_details
        });
    }
    
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('location_id');
            $table->dropColumn('location_detail_id');
        });
    }
};
