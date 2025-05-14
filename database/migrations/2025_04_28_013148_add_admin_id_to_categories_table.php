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
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable(); // Kolom admin_id
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null'); // Foreign key
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['admin_id']); // Hapus foreign key
            $table->dropColumn('admin_id');   // Hapus kolom admin_id
        });
    }
};
