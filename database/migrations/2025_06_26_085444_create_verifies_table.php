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
        Schema::create('verifies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verifyby_id')->constrained('users');
            $table->foreignId('requestby_id')->constrained('users');
            $table->string('status')->default('pending');
            $table->string('remark')->nullable();
            $table->foreignId('assembly_id')->constrained();
            $table->foreignId('responsibleby_id')->constrained('employees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifies');
    }
};
