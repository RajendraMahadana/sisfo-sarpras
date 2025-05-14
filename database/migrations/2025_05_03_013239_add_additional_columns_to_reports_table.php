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
    Schema::table('reports', function (Blueprint $table) {
        $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
        $table->integer('quantity')->nullable(); // Jumlah barang (untuk peminjaman/pengembalian)
        $table->string('status')->nullable();   // Status peminjaman/pengembalian (misalnya: "approved", "pending")
        $table->text('notes')->nullable();      // Catatan tambahan tentang laporan
    });
}

public function down()
{
    Schema::table('reports', function (Blueprint $table) {
        $table->dropForeign(['admin_id']);
        $table->dropColumn('admin_id');
        $table->dropColumn('quantity'); // Menghapus kolom quantity
        $table->dropColumn('status');  // Menghapus kolom status
        $table->dropColumn('notes');   // Menghapus kolom notes
    });
}
};
