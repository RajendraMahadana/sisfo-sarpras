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
    Schema::table('returns', function (Blueprint $table) {
        $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // Menambahkan admin_id
        $table->text('notes')->nullable(); // Menambahkan notes
    });
}

public function down()
{
    Schema::table('returns', function (Blueprint $table) {
        $table->dropForeign(['admin_id']); // Menghapus foreign key admin_id
        $table->dropColumn('admin_id'); // Menghapus kolom admin_id
        $table->dropColumn('notes'); // Menghapus kolom notes
    });
}
};
