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
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('item_id'); 
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null')->after('user_id'); 
            $table->text('notes')->nullable()->after('status'); 
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
            $table->dropColumn('notes');
        });
    }
};
