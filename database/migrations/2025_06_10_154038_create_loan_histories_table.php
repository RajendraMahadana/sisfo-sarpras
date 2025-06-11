<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('status', );
            $table->text('notes')->nullable();
            $table->timestamp('changed_at');
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null'); // Admin/User yang mengubah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_histories');
    }
};
