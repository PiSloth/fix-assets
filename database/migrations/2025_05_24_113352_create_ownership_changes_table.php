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
        Schema::create('ownership_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ownby_id')->nullable()->constrained('employees');
            $table->foreignId('transferto_id')->nullable()->constrained('employees');
            $table->foreignId('transferby_id')->constrained('users');
            $table->foreignId('approver_id')->constrained('users');
            $table->string('status')->default('pending');
            $table->foreignId('assembly_id')->constrained();
            $table->string('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownership_changes');
    }
};
